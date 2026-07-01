<?php

namespace Tests;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Client;
use Anthropic\Lib\Middleware\BetaFallbackState;
use Anthropic\Lib\Middleware\RefusalFallbackMiddleware;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Runner for the cross-SDK fable-fallback conformance suite
 * (`platform-sdks/fixtures/fable-fallback-middlewares`). Handles both case
 * formats, sniffed per case: the non-streaming wire-snapshot format
 * (`case.json` + `wire/N.*.json` + `app-response.json`) and the streaming
 * `.http` format (`turn-T.params.json` + `leg-N.resp.http` + partial
 * request asserts + event-for-event `sdk-response.assert.http`).
 *
 * Point `SUITE_DIR` at one suite directory (the dir holding `manifest.json`
 * and the case dirs — `non-streaming/` or `sanity-checks/non-streaming/`);
 * unset skips the runner. `RESULTS_OUT` (default
 * `/tmp/fable-php/results.json`) receives `[{case, actual}, ...]` for the
 * suite's `check-non-streaming.cjs` verdict script.
 *
 * Manifest statuses are triage metadata, never runner directives: every
 * diverging case fails — failing is the signal.
 *
 * @internal
 */
#[CoversNothing]
class FableFallbackConformanceTest extends TestCase
{
    private const VOLATILE_HEADERS = ['accept', 'authorization', 'x-api-key', 'user-agent', 'content-length', 'accept-encoding', 'connection', 'host'];

    /** @var list<array{case: string, actual: string}> */
    private static array $results = [];

    public static function tearDownAfterClass(): void
    {
        if ([] === self::$results) {
            return;
        }

        $out = getenv('RESULTS_OUT') ?: '/tmp/fable-php/results.json';
        @mkdir(dirname($out), recursive: true);
        file_put_contents($out, json_encode(self::$results, flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    #[DataProvider('cases')]
    public function testCase(string $name): void
    {
        $suite = getenv('SUITE_DIR');
        if ('' === $name || !is_string($suite)) {
            $this->markTestSkipped('SUITE_DIR is not set; skipping conformance runner');
        }

        try {
            $actual = self::runCase("{$suite}/{$name}");
        } catch (\Throwable $e) {
            $actual = "error: {$e->getMessage()}";
        }

        self::$results[] = ['case' => $name, 'actual' => $actual];

        if ('pass' !== $actual) {
            $manifest = json_decode(file_get_contents("{$suite}/manifest.json") ?: '', associative: true);
            $spec = is_array($manifest) && is_array($manifest[$name] ?? null) ? $manifest[$name] : [];
            $status = $spec['status'] ?? $spec['expect'] ?? '?';
            $status = is_string($status) ? $status : '?';
            $at = isset($spec['at']) && is_string($spec['at']) ? ' @ '.substr($spec['at'], 0, 80) : '';

            $this->fail("[{$status}{$at}] {$actual}");
        }

        $this->addToAssertionCount(1);
    }

    /** @return iterable<string,array{string}> */
    public static function cases(): iterable
    {
        $suite = getenv('SUITE_DIR');
        if (!is_string($suite) || '' === $suite) {
            yield 'suite-dir-unset' => [''];

            return;
        }

        $manifest = json_decode(file_get_contents("{$suite}/manifest.json") ?: '', associative: true);
        assert(is_array($manifest));
        foreach (array_keys($manifest) as $name) {
            $name = strval($name);
            if (!str_starts_with($name, '//')) {
                yield $name => [$name];
            }
        }
    }

    /**
     * Runs one case; returns 'pass' or the first divergence.
     */
    private static function runCase(string $dir): string
    {
        return file_exists("{$dir}/case.json")
            ? self::runWireSnapshotCase($dir)
            : self::runHttpCase($dir);
    }

    /**
     * Non-streaming wire-snapshot format: `case.json` + `wire/N.*.json`.
     */
    private static function runWireSnapshotCase(string $dir): string
    {
        $case = self::json("{$dir}/case.json");

        // scripted legs, served in order
        $legPaths = glob("{$dir}/wire/*.response.json") ?: [];
        usort($legPaths, static fn (string $a, string $b): int => intval(basename($a)) <=> intval(basename($b)));

        $transporter = new MockClient;
        foreach ($legPaths as $path) {
            $leg = self::json($path);
            // bare-message convention: a response file without a status key
            // is {status: 200, body: <whole file>}
            $rawStatus = $leg['status'] ?? null;
            [$status, $legBody] = array_key_exists('status', $leg)
                ? [is_numeric($rawStatus) ? intval($rawStatus) : 200, $leg['body'] ?? null]
                : [200, $leg];
            $transporter->addResponse(
                Psr17FactoryDiscovery::findResponseFactory()
                    ->createResponse($status)
                    ->withHeader('Content-Type', 'application/json')
                    ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($legBody, flags: JSON_UNESCAPED_SLASHES) ?: ''))
            );
        }

        // outermost capture: the chain's final response is the app-visible
        // outcome for every status — the SDK's typed throw happens above
        $box = new CapturedResponse;
        $capture = static function (RequestInterface $request, \Closure $next) use ($box): ResponseInterface {
            $response = $next($request);
            assert($response instanceof ResponseInterface);
            $box->response = $response;

            return $response;
        };

        $fallbacks = $case['fallbacks'] ?? [];
        assert(is_array($fallbacks));

        /** @var list<array<string,mixed>> $fallbacks */
        $fallbacks = array_values($fallbacks);
        $client = new Client(
            apiKey: 'conformance-test-key',
            requestOptions: [
                'transporter' => $transporter,
                'maxRetries' => 0,
                'middleware' => [$capture, new RefusalFallbackMiddleware($fallbacks)],
            ],
        );

        $requestHeaders = $case['requestHeaders'] ?? [];
        assert(is_array($requestHeaders));
        // @var array<string,string> $requestHeaders

        try {
            $client->request(
                method: 'post',
                path: 'v1/messages',
                // @phpstan-ignore-next-line argument.type
                headers: $requestHeaders,
                body: $case['request'] ?? [],
                convert: BetaMessage::class,
            );
        } catch (\Throwable) {
            // non-2xx surfaces as a typed error above the chain; the
            // captured response carries the app-visible {status, body}
        }

        // wire request asserts: same count, same order, full deep-equal
        $expectedPaths = glob("{$dir}/wire/*.request.json") ?: [];
        usort($expectedPaths, static fn (string $a, string $b): int => intval(basename($a)) <=> intval(basename($b)));
        $recorded = $transporter->getRequests();

        if (count($recorded) > count($expectedPaths)) {
            $n = count($expectedPaths) + 1;

            return "wire/{$n}.request: unexpected extra request (only ".count($expectedPaths).' scripted)';
        }

        foreach ($expectedPaths as $i => $path) {
            $n = intval(basename($path));
            if (!isset($recorded[$i])) {
                return "wire/{$n}.request: never sent";
            }

            $divergence = self::deepDiff(self::json($path), got: self::normalizeRequest($recorded[$i]), path: '');
            if (null !== $divergence) {
                return "wire/{$n}.request: {$divergence}";
            }
        }

        // app-visible outcome
        $captured = $box->take();
        if (is_null($captured)) {
            return 'app-response: no response reached the app';
        }
        $capturedBody = $captured->getBody();
        if ($capturedBody->isSeekable()) {
            $capturedBody->rewind();
        }
        $appBody = json_decode($capturedBody->getContents(), associative: true);
        $app = $captured->getStatusCode() >= 400
            ? ['status' => $captured->getStatusCode(), 'body' => $appBody]
            : $appBody;

        $divergence = self::deepDiff(self::json("{$dir}/app-response.json"), got: $app, path: '');
        if (null !== $divergence) {
            return "app-response: {$divergence}";
        }

        return 'pass';
    }

    /**
     * Streaming `.http` format: `(turn-T.)params.json` + `leg-N.resp.http`
     * legs + partial `leg-N.assert.req.http` asserts + event-for-event
     * `sdk-response.assert.http` (or partial `sdk-response.assert.json` for
     * a non-streaming turn) + optional subset `final-message.assert.json`.
     */
    private static function runHttpCase(string $dir): string
    {
        // multi-turn cases prefix every file with turn-T.; single-turn may
        // use bare names
        $turns = [1];
        foreach (glob("{$dir}/turn-*.params.json") ?: [] as $path) {
            if (1 === preg_match('/turn-(\d+)\.params\.json$/', $path, matches: $m)) {
                $turns[] = intval($m[1]);
            }
        }
        $turns = array_values(array_unique($turns));
        sort($turns);

        // queue every turn's legs in order on one transport
        $transporter = new MockClient;
        $legCounts = [];
        foreach ($turns as $turn) {
            $n = 1;
            while (null !== ($path = self::turnFile($dir, turn: $turn, name: "leg-{$n}.resp.http"))) {
                [$status, $headers, $body] = self::parseHttpFile($path);
                $response = Psr17FactoryDiscovery::findResponseFactory()->createResponse($status);
                foreach ($headers as $name => $value) {
                    $response = $response->withAddedHeader($name, $value);
                }
                $transporter->addResponse($response->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body)));
                ++$n;
            }
            $legCounts[$turn] = $n - 1;
        }

        $box = new CapturedResponse;
        $capture = static function (RequestInterface $request, \Closure $next) use ($box): ResponseInterface {
            $response = $next($request);
            assert($response instanceof ResponseInterface);
            $box->response = $response;

            return $response;
        };

        $firstParams = self::json(self::turnFile($dir, turn: $turns[0], name: 'params.json') ?? "{$dir}/params.json");
        $options = is_array($firstParams['options'] ?? null) ? $firstParams['options'] : [];
        $chain = is_array($options['clientSideFallbacks'] ?? null) ? array_values($options['clientSideFallbacks']) : [];

        /** @var list<array<string,mixed>> $chain */
        $recordedOffset = 0;
        $previousContent = null;

        /** @var array<string, BetaFallbackState> $fallbackStates one shared state per conversation id */
        $fallbackStates = [];

        foreach ($turns as $turn) {
            // turns without their own params file repeat the first turn's
            $paramsPath = self::turnFile($dir, turn: $turn, name: 'params.json')
                ?? self::turnFile($dir, turn: $turns[0], name: 'params.json');
            if (is_null($paramsPath)) {
                return "turn-{$turn}: params.json missing";
            }
            $turnSpec = self::json($paramsPath);
            $params = is_array($turnSpec['params'] ?? null) ? $turnSpec['params'] : [];
            $turnOptions = is_array($turnSpec['options'] ?? null) ? $turnSpec['options'] : [];

            // "<turn-1-final-content>" anywhere in params is replaced with
            // the previous turn's accumulated content
            if (!is_null($previousContent)) {
                /** @var array<string,mixed> $typedParams */
                $typedParams = $params;
                $params = self::substitutePlaceholder($typedParams, content: $previousContent);
            }

            $betas = $params['betas'] ?? null;
            unset($params['betas']);
            $headers = [];
            if (is_array($betas) && [] !== $betas) {
                $headers['anthropic-beta'] = implode(',', array_map(static fn ($b): string => is_string($b) ? $b : '', $betas));
            }

            $assertJsonPath = self::turnFile($dir, turn: $turn, name: 'sdk-response.assert.json');
            $streaming = is_null($assertJsonPath);
            if ($streaming) {
                $params['stream'] = true;
            }

            // the fixtures identify conversations by id; the SDK API is a
            // caller-owned shared state passed to the middleware constructor —
            // one per id, like the other SDKs. A fresh middleware per turn
            // reuses the same state object, so the pin carries across turns.
            $conversationId = $turnOptions['conversationId'] ?? $options['conversationId'] ?? null;
            $state = null;
            if (is_string($conversationId)) {
                $fallbackStates[$conversationId] ??= new BetaFallbackState;
                $state = $fallbackStates[$conversationId];
            }

            $client = new Client(
                apiKey: 'conformance-test-key',
                requestOptions: [
                    'transporter' => $transporter,
                    'maxRetries' => 0,
                    'middleware' => [$capture, new RefusalFallbackMiddleware($chain, state: $state)],
                ],
            );

            $box->clear();

            try {
                $client->request(
                    method: 'post',
                    path: 'v1/messages',
                    // @phpstan-ignore-next-line argument.type
                    headers: $headers,
                    body: $params,
                    convert: BetaMessage::class,
                );
            } catch (\Throwable) {
                // surfaced HTTP errors are judged from the captured response
            }

            $prefix = count($turns) > 1 ? "turn-{$turn}." : '';

            // drain the app-visible body first: the splicer issues hop
            // retries lazily, while the consumer reads
            $captured = $box->take();
            if (is_null($captured)) {
                return "{$prefix}sdk-response: no response reached the app";
            }
            $capturedBody = $captured->getBody();
            if ($capturedBody->isSeekable()) {
                $capturedBody->rewind();
            }
            $rawBody = $capturedBody->getContents();

            // request asserts for this turn's legs
            $recorded = $transporter->getRequests();
            $n = 1;
            while (null !== ($assertPath = self::turnFile($dir, turn: $turn, name: "leg-{$n}.assert.req.http"))) {
                $legLabel = "{$prefix}leg-{$n}";
                if (!isset($recorded[$recordedOffset + $n - 1])) {
                    return "{$legLabel} request: request never sent";
                }
                $divergence = self::legAssert(self::parseHttpRequestFile($assertPath), got: $recorded[$recordedOffset + $n - 1]);
                if (null !== $divergence) {
                    return "{$legLabel} request: {$divergence}";
                }
                ++$n;
            }
            $recordedOffset += $legCounts[$turn];

            if (!$streaming) {
                if ($captured->getStatusCode() >= 400) {
                    return "{$prefix}response: HTTP {$captured->getStatusCode()} surfaced";
                }
                $appBody = json_decode($rawBody, associative: true);
                $expected = self::json($assertJsonPath);
                foreach ($expected as $key => $value) {
                    $gotValue = is_array($appBody) ? ($appBody[$key] ?? null) : null;
                    $divergence = self::deepDiff($value, got: $gotValue, path: "/{$key}");
                    if (null !== $divergence) {
                        return "{$prefix}response {$divergence}";
                    }
                }

                continue;
            }

            if ($captured->getStatusCode() >= 400) {
                return "HTTP {$captured->getStatusCode()} surfaced (expected stitched stream)";
            }

            // live output: unterminated final frames are discarded per the
            // SSE spec; assert files are event lists, so they flush
            $gotEvents = self::parseSse($rawBody, flushFinal: false);
            $assertHttpPath = self::turnFile($dir, turn: $turn, name: 'sdk-response.assert.http');
            if (!is_null($assertHttpPath)) {
                // a turn without a stream assert pins only its wire requests
                [, , $assertBody] = self::parseHttpFile($assertHttpPath);
                $wantEvents = self::parseSse($assertBody, flushFinal: true);

                $divergence = self::eventStreamDiff($wantEvents, got: $gotEvents);
                if (null !== $divergence) {
                    return $divergence;
                }
            }

            // accumulate the app-visible stream for final-message asserts and
            // the next turn's placeholder. The streaming accumulator ships
            // with the streaming helpers, separately from this middleware;
            // when it is absent these (secondary) asserts are skipped while
            // the wire-request and SSE asserts above still pin behavior.
            $final = self::accumulateFinal($gotEvents);
            $content = is_array($final) && is_array($final['content'] ?? null) ? array_values($final['content']) : null;
            $previousContent = $content;

            $finalAssertPath = self::turnFile($dir, turn: $turn, name: 'final-message.assert.json');
            if (!is_null($finalAssertPath) && is_array($final)) {
                $divergence = self::subsetDiff(self::json($finalAssertPath), got: $final, path: 'final-message');
                if (null !== $divergence) {
                    return $divergence;
                }
            }
        }

        return 'pass';
    }

    /**
     * Accumulates SSE events into the app-visible final message via the
     * streaming helpers' MessageAccumulator. That accumulator ships
     * separately from this middleware; returns null when it is unavailable.
     *
     * @param list<array<string,mixed>> $events
     *
     * @return array<string,mixed>|null
     */
    private static function accumulateFinal(array $events): ?array
    {
        $accumulatorClass = 'Anthropic\\Lib\\Streaming\\MessageAccumulator';
        if (!class_exists($accumulatorClass)) {
            return null;
        }

        // @phpstan-ignore-next-line staticMethod.dynamicCall
        $accumulator = $accumulatorClass::forBetaMessages();
        foreach ($events as $event) {
            // @phpstan-ignore-next-line method.nonObject
            $accumulator->accumulate($event);
        }
        // @phpstan-ignore-next-line method.nonObject
        $final = $accumulator->message()->jsonSerialize();

        $out = [];
        foreach ($final as $key => $value) {
            $out[strval($key)] = $value;
        }

        return $out;
    }

    /**
     * Resolves `turn-T.name`, falling back to the bare name for turn 1.
     */
    private static function turnFile(string $dir, int $turn, string $name): ?string
    {
        $prefixed = "{$dir}/turn-{$turn}.{$name}";
        if (file_exists($prefixed)) {
            return $prefixed;
        }

        return 1 === $turn && file_exists("{$dir}/{$name}") ? "{$dir}/{$name}" : null;
    }

    /**
     * Parses a raw HTTP message file: start line, headers (lowercased, LF or
     * CRLF), then the body verbatim.
     *
     * @return array{int,array<string,string>,string}
     */
    private static function parseHttpFile(string $path): array
    {
        $raw = file_get_contents($path);
        assert(is_string($raw));

        $separator = str_contains($raw, "\r\n\r\n") ? "\r\n\r\n" : "\n\n";
        [$head, $body] = str_contains($raw, $separator) ? explode($separator, $raw, limit: 2) : [$raw, ''];

        $lines = preg_split('/\r?\n/', $head) ?: [];
        $startLine = strval(array_shift($lines));
        $fields = preg_split('/\s+/', $startLine) ?: [];
        $status = isset($fields[1]) && is_numeric($fields[1]) ? intval($fields[1]) : 200;

        $headers = [];
        foreach ($lines as $line) {
            if (!str_contains($line, ':')) {
                continue;
            }
            [$name, $value] = explode(':', $line, limit: 2);
            $headers[strtolower(trim($name))] = trim($value);
        }

        return [$status, $headers, $body];
    }

    /**
     * Parses a request assert file: start line carries method and path.
     *
     * @return array{method: string, path: string, headers: array<string,string>, body: array<string,mixed>|null}
     */
    private static function parseHttpRequestFile(string $path): array
    {
        $raw = file_get_contents($path);
        assert(is_string($raw));

        $separator = str_contains($raw, "\r\n\r\n") ? "\r\n\r\n" : "\n\n";
        [$head, $body] = str_contains($raw, $separator) ? explode($separator, $raw, limit: 2) : [$raw, ''];

        $lines = preg_split('/\r?\n/', $head) ?: [];
        $startLine = strval(array_shift($lines));
        $fields = preg_split('/\s+/', $startLine) ?: [];

        $headers = [];
        foreach ($lines as $line) {
            if (!str_contains($line, ':')) {
                continue;
            }
            [$name, $value] = explode(':', $line, limit: 2);
            $headers[strtolower(trim($name))] = trim($value);
        }

        $decodedBody = '' === trim($body) ? null : json_decode($body, associative: true);
        $bodyOut = null;
        if (is_array($decodedBody)) {
            $bodyOut = [];
            foreach ($decodedBody as $k => $v) {
                $bodyOut[strval($k)] = $v;
            }
        }

        return [
            'method' => $fields[0] ?? 'POST',
            'path' => $fields[1] ?? '',
            'headers' => $headers,
            'body' => $bodyOut,
        ];
    }

    /**
     * Partial request assert: method and path from the start line; listed
     * headers exact, except `anthropic-beta` (comma-split subset) and
     * `anthropic-beta-forbidden` (negative: none of its betas may be sent);
     * top-level listed body keys deep-equal, an expected null pinning
     * absent-or-null.
     *
     * @param array{method: string, path: string, headers: array<string,string>, body: array<string,mixed>|null} $want
     */
    private static function legAssert(array $want, RequestInterface $got): ?string
    {
        if ('' !== $want['method'] && strtolower($want['method']) !== strtolower($got->getMethod())) {
            return "method: want {$want['method']} got {$got->getMethod()}";
        }
        if ('' !== $want['path'] && $want['path'] !== $got->getUri()->getPath()) {
            return "path: want {$want['path']} got {$got->getUri()->getPath()}";
        }

        foreach ($want['headers'] as $name => $wantValue) {
            $sent = [];
            foreach (explode(',', $got->getHeaderLine('anthropic-beta')) as $member) {
                $member = trim($member);
                if ('' !== $member) {
                    $sent[$member] = true;
                }
            }

            if ('anthropic-beta' === $name) {
                foreach (explode(',', $wantValue) as $member) {
                    $member = trim($member);
                    if ('' !== $member && !isset($sent[$member])) {
                        return "header anthropic-beta missing '{$member}' (got: {$got->getHeaderLine('anthropic-beta')})";
                    }
                }

                continue;
            }

            if ('anthropic-beta-forbidden' === $name) {
                foreach (explode(',', $wantValue) as $member) {
                    $member = trim($member);
                    if ('' !== $member && isset($sent[$member])) {
                        return "header anthropic-beta carries forbidden '{$member}'";
                    }
                }

                continue;
            }

            $gotValue = $got->getHeaderLine($name);
            if ($gotValue !== $wantValue) {
                return "header {$name}: want '{$wantValue}' got '{$gotValue}'";
            }
        }

        if (is_null($want['body'])) {
            return null;
        }

        $gotBodyStream = $got->getBody();
        $gotBodyStream->rewind();
        $gotBody = json_decode($gotBodyStream->getContents(), associative: true);
        $gotBody = is_array($gotBody) ? $gotBody : [];

        foreach ($want['body'] as $key => $wantValue) {
            $present = array_key_exists($key, $gotBody);
            if (is_null($wantValue)) {
                if ($present && !is_null($gotBody[$key])) {
                    return "body /{$key}: want null got ".self::compact($gotBody[$key]);
                }

                continue;
            }
            if (!$present) {
                return "body /{$key}: missing (want ".self::compact($wantValue).')';
            }
            $divergence = self::deepDiff($wantValue, got: $gotBody[$key], path: "/{$key}");
            if (null !== $divergence) {
                return 'body '.$divergence;
            }
        }

        return null;
    }

    /**
     * Parses SSE text into decoded event payloads, dropping pings. Live
     * output discards an unterminated final frame per the SSE spec; assert
     * files are event lists and flush it.
     *
     * @return list<array<string,mixed>>
     */
    private static function parseSse(string $text, bool $flushFinal): array
    {
        $events = [];
        $frames = preg_split('/\r?\n\r?\n/', $text) ?: [];
        $last = count($frames) - 1;

        foreach ($frames as $i => $frame) {
            if ($i === $last && !$flushFinal && '' !== trim($frame)) {
                break; // unterminated final frame: discard from live output
            }
            $data = '';
            foreach (preg_split('/\r?\n/', $frame) ?: [] as $line) {
                if (str_starts_with($line, 'data:')) {
                    $data .= substr($line, 5)."\n";
                }
            }
            if ('' === trim($data)) {
                continue;
            }
            $decoded = json_decode($data, associative: true);
            if (!is_array($decoded) || 'ping' === ($decoded['type'] ?? null)) {
                continue;
            }
            $event = [];
            foreach ($decoded as $k => $v) {
                $event[strval($k)] = $v;
            }
            $events[] = $event;
        }

        return $events;
    }

    /**
     * Event-for-event stream equality, first divergence wins.
     *
     * @param list<array<string,mixed>> $want
     * @param list<array<string,mixed>> $got
     */
    private static function eventStreamDiff(array $want, array $got): ?string
    {
        foreach ($want as $i => $wantEvent) {
            $type = is_string($wantEvent['type'] ?? null) ? $wantEvent['type'] : '?';
            $label = isset($wantEvent['index']) && is_int($wantEvent['index']) ? "{$type}@{$wantEvent['index']}" : $type;
            $n = $i; // the suite numbers events zero-based

            if (!isset($got[$i])) {
                return "event {$n} ({$label}): missing (stream ended)";
            }
            $divergence = self::deepDiff($wantEvent, got: $got[$i], path: '');
            if (null !== $divergence) {
                return "event {$n} ({$label}): payload mismatch ({$divergence})";
            }
        }

        if (count($got) > count($want)) {
            $extra = $got[count($want)];
            $n = count($want); // zero-based

            return "event {$n}: extra ".(is_string($extra['type'] ?? null) ? $extra['type'] : '?');
        }

        return null;
    }

    /**
     * Subset match for final-message asserts: every listed key must exist
     * and match recursively; arrays match element-wise with equal length; an
     * expected null matches null or an absent key — never a zero value.
     */
    private static function subsetDiff(mixed $want, mixed $got, string $path): ?string
    {
        if (is_null($want)) {
            return is_null($got) ? null : "{$path}: want null got ".self::compact($got);
        }

        if (is_array($want) && !array_is_list($want)) {
            if (!is_array($got)) {
                return "{$path}: want object got ".self::compact($got);
            }
            foreach ($want as $key => $value) {
                if (is_null($value)) {
                    if (array_key_exists($key, $got) && !is_null($got[$key])) {
                        return "{$path}/{$key}: want null got ".self::compact($got[$key]);
                    }

                    continue;
                }
                if (!array_key_exists($key, $got)) {
                    return "{$path}/{$key}: missing (want ".self::compact($value).')';
                }
                $divergence = self::subsetDiff($value, got: $got[$key], path: "{$path}/{$key}");
                if (null !== $divergence) {
                    return $divergence;
                }
            }

            return null;
        }

        if (is_array($want)) {
            if (!is_array($got) || !array_is_list($got)) {
                return "{$path}: want array got ".self::compact($got);
            }
            if (count($want) !== count($got)) {
                return "{$path}: want ".count($want).' items got '.count($got);
            }
            foreach ($want as $i => $value) {
                $divergence = self::subsetDiff($value, got: $got[$i], path: "{$path}[{$i}]");
                if (null !== $divergence) {
                    return $divergence;
                }
            }

            return null;
        }

        $equal = (is_int($want) || is_float($want)) && (is_int($got) || is_float($got))
            ? abs($want - $got) < PHP_FLOAT_EPSILON
            : $want === $got;

        return $equal ? null : "{$path}: want ".self::compact($want).' got '.self::compact($got);
    }

    /**
     * Replaces the `"<turn-1-final-content>"` marker anywhere in params with
     * the previous turn's accumulated content blocks.
     *
     * @param array<string,mixed> $params
     * @param list<mixed> $content
     *
     * @return array<string,mixed>
     */
    private static function substitutePlaceholder(array $params, array $content): array
    {
        $walk = static function (mixed $value) use (&$walk, $content): mixed {
            if ('<turn-1-final-content>' === $value) {
                return $content;
            }
            if (is_array($value)) {
                return array_map($walk, $value);
            }

            return $value;
        };

        $out = $walk($params);
        if (!is_array($out)) {
            return $params;
        }

        $result = [];
        foreach ($out as $k => $v) {
            $result[strval($k)] = $v;
        }

        return $result;
    }

    /**
     * Snapshot view of a recorded request: lowercase method, URL without its
     * query string, lowercased headers minus the volatile deny-list, decoded
     * body.
     *
     * @return array<string,mixed>
     */
    private static function normalizeRequest(RequestInterface $request): array
    {
        $headers = [];
        foreach (array_keys($request->getHeaders()) as $rawName) {
            $name = strtolower(strval($rawName));
            if (in_array($name, self::VOLATILE_HEADERS, strict: true) || str_starts_with($name, 'x-stainless-')) {
                continue;
            }
            $headers[$name] = $request->getHeaderLine($rawName);
        }
        ksort($headers);

        $body = $request->getBody();
        $body->rewind();

        return [
            'method' => strtolower($request->getMethod()),
            'url' => (string) $request->getUri()->withQuery(''),
            'headers' => $headers,
            'body' => json_decode($body->getContents(), associative: true),
        ];
    }

    /**
     * Symmetric deep-equal with the suite's rules: an expected `null`
     * matches null or an absent key; extra got-keys diverge; arrays match
     * length and order; ints and floats compare numerically. Returns the
     * first divergence as a JSON-pointer message, or null.
     */
    private static function deepDiff(mixed $want, mixed $got, string $path): ?string
    {
        if (is_null($want)) {
            return is_null($got) ? null : "{$path}: want null got ".self::compact($got);
        }

        if (is_array($want) && !array_is_list($want)) {
            if (!is_array($got) || array_is_list($got)) {
                return "{$path}: want object got ".self::compact($got);
            }

            foreach ($want as $key => $value) {
                $present = array_key_exists($key, $got);
                if (is_null($value)) {
                    if ($present && !is_null($got[$key])) {
                        return "{$path}/{$key}: want null got ".self::compact($got[$key]);
                    }

                    continue;
                }
                if (!$present) {
                    return "{$path}/{$key}: missing (want ".self::compact($value).')';
                }
                $divergence = self::deepDiff($value, got: $got[$key], path: "{$path}/{$key}");
                if (null !== $divergence) {
                    return $divergence;
                }
            }

            foreach ($got as $key => $value) {
                if (!array_key_exists($key, $want)) {
                    return "{$path}/{$key}: unexpected key (got ".self::compact($value).')';
                }
            }

            return null;
        }

        if (is_array($want)) {
            if (!is_array($got) || !array_is_list($got)) {
                return "{$path}: want array got ".self::compact($got);
            }
            if (count($want) !== count($got)) {
                return "{$path}: want ".count($want).' items got '.count($got);
            }

            foreach ($want as $i => $value) {
                $divergence = self::deepDiff($value, got: $got[$i], path: "{$path}/{$i}");
                if (null !== $divergence) {
                    return $divergence;
                }
            }

            return null;
        }

        // ints and floats compare numerically (999 == 999.0)
        $equal = (is_int($want) || is_float($want)) && (is_int($got) || is_float($got))
            ? abs($want - $got) < PHP_FLOAT_EPSILON
            : $want === $got;

        return $equal ? null : "{$path}: want ".self::compact($want).' got '.self::compact($got);
    }

    private static function compact(mixed $value): string
    {
        $encoded = json_encode($value, flags: JSON_UNESCAPED_SLASHES) ?: 'null';

        return strlen($encoded) > 80 ? substr($encoded, 0, 77).'...' : $encoded;
    }

    /** @return array<string,mixed> */
    private static function json(string $path): array
    {
        $decoded = json_decode(file_get_contents($path) ?: '', associative: true, flags: JSON_THROW_ON_ERROR);
        assert(is_array($decoded));

        $out = [];
        foreach ($decoded as $key => $value) {
            $out[strval($key)] = $value;
        }

        return $out;
    }
}

/**
 * Mutable holder the outermost capture middleware writes the chain's final
 * response into.
 *
 * @internal
 */
final class CapturedResponse
{
    public ?ResponseInterface $response = null;

    public function take(): ?ResponseInterface
    {
        return $this->response;
    }

    public function clear(): void
    {
        $this->response = null;
    }
}
