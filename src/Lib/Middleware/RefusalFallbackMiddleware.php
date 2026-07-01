<?php

declare(strict_types=1);

namespace Anthropic\Lib\Middleware;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaFallbackParam;
use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Util;
use Anthropic\Lib\Helpers\StainlessHelperHeader;
use Anthropic\Middleware;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Middleware that retries refused `/v1/messages` requests down a fallback
 * model chain, conforming to the cross-SDK fable-fallbacks conformance
 * suite.
 *
 * ```php
 * $client = new Client(requestOptions: [
 *     'middleware' => [new RefusalFallbackMiddleware([['model' => 'claude-opus-4-8']])],
 * ]);
 * ```
 *
 * On a refusal the next chain entry's `model` (plus its overrides on the
 * server's allowlist) merges over the original params, the refusal's
 * `fallback_credit_token` rides along when one was minted, and the final
 * leg's response is returned to the app untouched. The credit beta is
 * auto-armed on every leg the middleware handles; fallback seam blocks in
 * assistant history are stripped from the outgoing wire (they are
 * parse-gated behind the server-side beta, which is caller-owned and never
 * sent here). Requests sharing a {@see BetaFallbackState} (passed to the
 * constructor, or per-request via the `fallbackState` request option, which
 * overrides the constructor state) pin to the accepting entry, so follow-up
 * turns skip models that already refused — explicit-state pinning only;
 * history is never consulted.
 *
 * Streaming requests are retried in place: the retry's events are spliced
 * onto the open stream behind a `fallback` seam block, with one
 * message_start, monotonic block indices, and a merged usage.iterations
 * ledger. A body carrying the server-side `fallbacks` param conflicts with
 * the middleware and errors before any request reaches the wire.
 */
final class RefusalFallbackMiddleware implements Middleware
{
    /**
     * Entry keys that merge into a retry leg: the server applies chain
     * entries through FALLBACK_V2_INFERENCE_PARAM_OVERRIDES, and the client
     * chain mirrors it. Non-allowlisted entry keys are dropped, not sent.
     */
    private const ENTRY_OVERRIDE_ALLOWLIST = [
        'model' => true,
        'max_tokens' => true,
        'thinking' => true,
        'output_config' => true,
        'speed' => true,
    ];

    /** @var list<array<string,mixed>> the chain, dumped to wire shape */
    private array $fallbacks;

    /** @var (callable(mixed,array<string,mixed>,int): void)|null */
    private $onFallback;

    /** Caller-owned pin, mutated in place; null leaves every request unpinned. */
    private ?BetaFallbackState $state;

    private StreamFactoryInterface $streamFactory;

    /** One warning per instance when a fallback fires without a shared state. */
    private bool $warnedMissingState = false;

    /**
     * Stamped on every leg this instance sends so that, when the same
     * instance is registered twice (client-level and request-level middleware
     * compose), the inner registration stands down instead of nesting a
     * second walker. The marker rides the request so concurrent requests
     * sharing one middleware don't interfere; the value is a per-instance
     * random token so an externally supplied header cannot trip the bypass.
     */
    private const REENTRY_HEADER = 'x-anthropic-fallback-reentry';

    private readonly string $reentryToken;

    /**
     * @param list<BetaFallbackParam|array<string,mixed>> $fallbacks the model
     *                                                               chain to walk on refusals, in order; same shape as the server-side
     *                                                               `fallbacks` body param
     * @param callable(mixed,array<string,mixed>,int): void|null $onFallback
     *                                                                        called on each hop with the refused message, the entry about to be
     *                                                                        tried, and its index
     * @param BetaFallbackState|null $state shared pin for a sequence of
     *                                      requests (the turns of one conversation); mutated in place when a
     *                                      model refuses, so follow-up turns skip models that already refused
     * @param StreamFactoryInterface|null $streamFactory builds replacement
     *                                                   request and response bodies; discovered when null
     */
    public function __construct(
        array $fallbacks,
        ?callable $onFallback = null,
        ?BetaFallbackState $state = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        $this->fallbacks = array_map(
            static function ($entry): array {
                $dumped = self::bodyArray(Conversion::dump(BetaFallbackParam::class, value: $entry));
                if (is_null($dumped) || !is_string($dumped['model'] ?? null) || '' === $dumped['model']) {
                    throw new \InvalidArgumentException('each fallback must carry a model; a fallback without one merges to a no-op');
                }

                return $dumped;
            },
            $fallbacks,
        );
        $this->onFallback = $onFallback;
        $this->state = $state;
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->reentryToken = bin2hex(random_bytes(16));
    }

    /**
     * @param \Closure(RequestInterface): ResponseInterface $sendRequest
     */
    public function handle(
        RequestInterface $request,
        \Closure $sendRequest,
        ?RequestOptions $options = null
    ): ResponseInterface {
        $body = self::bodyArray($this->requestBody($request));

        if (
            [] === $this->fallbacks
            || 'POST' !== strtoupper($request->getMethod())
            || !str_ends_with($request->getUri()->getPath(), '/v1/messages')
            || is_null($body)
        ) {
            return $sendRequest($request);
        }

        parse_str($request->getUri()->getQuery(), $query);
        if ('true' !== ($query['beta'] ?? null)) {
            // Refusals minted by the non-beta surface carry no
            // fallback_credit_token; the middleware handles only
            // beta.messages requests and stands down on everything else.
            return $sendRequest($request);
        }

        foreach ($request->getHeader('anthropic-beta') as $line) {
            if (in_array('server-side-fallback-2026-06-01', array_map(trim(...), explode(',', $line)), true)) {
                // Two owners for one request is never resolved by guessing:
                // silently stripping the caller's seams or arming both betas
                // are equally wrong, so the conflict errors before any
                // request reaches the wire — the header twin of the
                // `fallbacks` body-param conflict below.
                throw new AnthropicException(
                    'Arming the `server-side-fallback-2026-06-01` beta is not supported when using the '
                    .'RefusalFallbackMiddleware. Either remove the middleware to let the API handle refusal '
                    .'fallbacks server-side, or drop the beta to let the middleware handle them client-side.',
                );
            }
        }

        if (isset($body['fallbacks'])) {
            // Gaveled: the server-side chain and the client-side middleware
            // cannot both own a request — error before anything reaches the
            // wire rather than guess which chain the caller meant.
            throw new AnthropicException(
                'Sending the `fallbacks` request param is not supported when using the '
                .'RefusalFallbackMiddleware. Either remove the middleware and send `fallbacks` with the '
                .'`server-side-fallback-2026-06-01` beta header to let the API handle refusal fallbacks, '
                .'or omit the `fallbacks` param to let the middleware handle them client-side.',
            );
        }
        if (isset($body['fallback'])) {
            // A single server-side fallback owns this request; the
            // middleware stands down entirely — no arming, no pin.
            return $sendRequest($request);
        }

        // Registered at both client and request level (an easy mistake —
        // the levels compose), the middleware would nest two walkers: the
        // inner one rebuilds legs from the original body, clobbering the
        // outer's redemptions and squaring the request count. One walk per
        // request: a leg sent by an engaged walker carries the marker, so the
        // inner registration strips it and passes through untouched. The
        // marker rides the leg request only, so SDK retry attempts — which
        // re-enter the chain from above with the original request — walk
        // normally.
        if ($request->getHeaderLine(self::REENTRY_HEADER) === $this->reentryToken) {
            return $sendRequest($request->withoutHeader(self::REENTRY_HEADER));
        }
        $token = $this->reentryToken;
        $next = static fn (RequestInterface $r): ResponseInterface => $sendRequest($r->withHeader(self::REENTRY_HEADER, $token));

        $streaming = true === ($body['stream'] ?? null);
        // The refusal detector reads response bodies, and some transports
        // decode compressed bodies while leaving Content-Encoding in place —
        // indistinguishable from an undecoded body. Requesting identity
        // sidesteps encoding entirely on handled requests; the
        // Content-Encoding stand-down gates stay as a backstop.
        $request = $request->withHeader('Accept-Encoding', 'identity');
        $request = self::withCreditBeta($request);
        $request = self::withHelperTag($request);
        // orphan tool_use blocks in seam-bearing turns would fail validation
        // when echoed, so the streaming path scrubs them before the strip
        $body = self::withoutSeamBlocks($body, scrubOrphans: $streaming);

        $state = $options->fallbackState ?? $this->state;
        $index = $this->startIndex($state);

        // merging an empty entry is the identity, so index -1 (original
        // params) needs no special case
        $attemptBody = self::mergeEntry($body, entry: $this->fallbacks[$index] ?? []);
        // The first attempt goes out as the caller spelled it — a caller-set
        // `fallback_credit_token` included — but retries never inherit it:
        // each retry carries the fresh token its own refusal minted, or none.
        unset($body['fallback_credit_token']);

        if ($streaming) {
            return $this->handleStreaming($request, next: $next, body: $body, attemptBody: $attemptBody, startIndex: $index, state: $state);
        }

        return $this->walkChain($request, next: $next, body: $body, attemptBody: $attemptBody, index: $index, state: $state);
    }

    /**
     * Merges a chain entry's allowlisted overrides over the original body.
     *
     * @param array<string,mixed> $body
     * @param array<string,mixed> $entry
     *
     * @return array<string,mixed>
     *
     * @internal shared with StreamSplicer — one override allowlist
     */
    public static function mergeEntry(array $body, array $entry): array
    {
        $overrides = array_filter(
            array_intersect_key($entry, self::ENTRY_OVERRIDE_ALLOWLIST),
            static fn ($v) => null !== $v, // null means "no override", as server-side
        );

        return [...$body, ...$overrides];
    }

    /**
     * True when a response is a still-encoded `text/event-stream` 200 — the
     * only shape the splice acts on.
     *
     * @internal shared with the per-stream splice
     */
    public static function isEventStream(ResponseInterface $response): bool
    {
        if (200 !== $response->getStatusCode() || '' !== $response->getHeaderLine('Content-Encoding')) {
            return false;
        }
        $mediaType = strtolower(trim(explode(';', $response->getHeaderLine('Content-Type'))[0]));

        return 'text/event-stream' === $mediaType;
    }

    /**
     * The non-streaming retry loop: send, read the refusal, merge the next
     * entry, repeat — then rebuild the served envelope with the seams and
     * the whole-chain ledger.
     *
     * @param \Closure(RequestInterface): ResponseInterface $next
     * @param array<string,mixed> $body
     * @param array<string,mixed> $attemptBody
     */
    private function walkChain(
        RequestInterface $request,
        \Closure $next,
        array $body,
        array $attemptBody,
        int $index,
        ?BetaFallbackState $state,
    ): ResponseInterface {
        $response = $next($this->withBody($request, body: $attemptBody));

        $seams = [];
        $ledger = [];
        $prevModel = is_string($attemptBody['model'] ?? null) ? $attemptBody['model'] : null;

        while ($index < count($this->fallbacks) - 1) {
            [$response, $refusal] = $this->refusal($response);
            if (is_null($refusal)) {
                break;
            }
            [$message, $token] = $refusal;
            // Seam models carry the caller's spelling: the primary seam uses
            // params.model exactly as requested (alias included), later hops
            // their chain-entry ids — matching the server's own stitching.
            $ledger[] = self::iterationEntry($message, type: 'message', model: $prevModel);

            // The pin advances on the hop, not on acceptance: a model that
            // refused is never re-asked, even if the chain ends up exhausted.
            // The guarantee holds by MODEL, not index — the server 400s
            // same-model redemptions, so an entry naming the model that just
            // refused is skipped, never re-asked.
            do {
                ++$index;
            } while ($index < count($this->fallbacks) && ($this->fallbacks[$index]['model'] ?? null) === $prevModel);
            if ($index >= count($this->fallbacks)) {
                break;
            }
            $entry = $this->fallbacks[$index];
            $this->pin($state, index: $index);
            if (null !== $this->onFallback) {
                ($this->onFallback)($message, $entry, $index);
            }

            $legBody = self::mergeEntry($body, entry: $entry);
            if (null !== $token) {
                $legBody['fallback_credit_token'] = $token;
            }
            $response->getBody()->close();
            $response = $next($this->withBody($request, body: $legBody));

            if (null !== $token && 400 === $response->getStatusCode()) {
                // The token contract's documented recovery: one re-send
                // without it. A 400 caused by something else just fails again.
                // The seam block is tied to the redemption, so the recovered
                // hop carries none — matching the server's stitching.
                $response->getBody()->close();
                $response = $next($this->withBody($request, body: self::mergeEntry($body, entry: $entry)));
            } elseif (null !== $token && 200 === $response->getStatusCode()) {
                // A redeemed hop mirrors the server-side stitched envelope: a
                // fallback seam block is prepended to the serving content.
                $seams[] = [
                    'type' => 'fallback',
                    'from' => ['model' => $prevModel],
                    'to' => ['model' => $entry['model']],
                ];
            }
            $prevModel = is_string($entry['model'] ?? null) ? $entry['model'] : $prevModel;
        }

        return [] === $seams ? $response : $this->withSeamsPrepended($response, seams: $seams, ledger: $ledger, servingModel: $prevModel);
    }

    /**
     * One usage.iterations entry, in wire shape, from a hop's message.
     *
     * @return array<string,mixed>
     */
    private static function iterationEntry(mixed $message, string $type, ?string $model): array
    {
        $entry = ['type' => $type];
        if (null !== $model && '' !== $model) {
            $entry['model'] = $model;
        }
        $usage = self::field($message, property: 'usage', key: 'usage');
        foreach ([
            'input_tokens' => 'inputTokens',
            'output_tokens' => 'outputTokens',
            'cache_read_input_tokens' => 'cacheReadInputTokens',
            'cache_creation_input_tokens' => 'cacheCreationInputTokens',
        ] as $key => $property) {
            $value = self::field($usage, property: $property, key: $key);
            if (is_int($value) || is_float($value)) {
                $entry[$key] = $value;
            }
        }

        return $entry;
    }

    /**
     * The chain entry this request starts at (-1 = the original params).
     *
     * Only an explicit {@see BetaFallbackState} pin moves the start; without
     * one the request starts at the original params.
     */
    private function startIndex(?BetaFallbackState $state): int
    {
        $index = $state->index ?? -1;
        if ($index < -1 || $index >= count($this->fallbacks)) {
            throw new AnthropicException(sprintf(
                'BetaFallbackState.index %d is out of bounds for a chain of %d fallback(s); was the state shared with a different middleware?',
                $index,
                count($this->fallbacks),
            ));
        }

        return $index;
    }

    /**
     * Pins requests sharing the state to the entry being tried, or warns
     * once that there is none — without a shared state, follow-up requests
     * retry models that already refused.
     */
    private function pin(?BetaFallbackState $state, int $index): void
    {
        if (null !== $state) {
            $state->index = $index;
        } elseif (!$this->warnedMissingState) {
            $this->warnedMissingState = true;
            error_log(
                'anthropic-sdk: RefusalFallbackMiddleware fell back without a shared `BetaFallbackState`; '
                .'follow-up requests will retry models that already refused. Pass a shared '
                .'`new BetaFallbackState` to the constructor to pin them to the accepted model.'
            );
        }
    }

    /**
     * The streaming path: the first attempt's SSE stream is wrapped in a
     * pull-based splicer that retries refused hops down the chain and
     * splices the continuation onto the open stream, in the framing the
     * server's own fallback chain produces. Non-SSE first responses
     * surface verbatim — there is no refusal to act on.
     *
     * @param \Closure(RequestInterface): ResponseInterface $next
     * @param array<string,mixed> $body
     * @param array<string,mixed> $attemptBody
     */
    private function handleStreaming(
        RequestInterface $request,
        \Closure $next,
        array $body,
        array $attemptBody,
        int $startIndex,
        ?BetaFallbackState $state,
    ): ResponseInterface {
        // @phpstan-ignore-next-line argument.type
        $send = fn (array $b): ResponseInterface => $next($this->withBody($request, body: $b));

        $response = $send($attemptBody);
        if (!self::isEventStream($response)) {
            return $response;
        }

        $onHop = function (int $index, mixed $refused) use ($state): void {
            $this->pin($state, index: $index);
            if (null !== $this->onFallback) {
                ($this->onFallback)($refused, $this->fallbacks[$index], $index);
            }
        };

        // The splice is a PER-STREAM stateful object (~20 mutable fields
        // driven by read()) — it cannot live as instance state on the
        // long-lived middleware without leaking across requests, so it is an
        // anonymous class instantiated once per spliced stream, capturing the
        // chain/body/send/onHop. PHP port of the Go SDK's pull-based stream
        // splicer: all hop retries happen while the consumer reads, and the
        // spliced output is one SSE stream.
        $splicer = new class(
            $response,
            $body,
            $this->fallbacks,
            $startIndex + 1,
            $send,
            $onHop,
        ) {
            // ── chain state (survives across hops) ──
            /** @var list<array<string,mixed>> */
            private array $ledger = [];

            /** @var list<mixed> the growing prefill-claim continuation */
            private array $continuation = [];

            private int $lastClaimCount = 0;

            private string $token = '';

            private string $primaryID = '';

            /**
             * Spliced-stream index arithmetic, in one sentence: `nextIndex` is
             * the next unused index on the OUTPUT stream, `hopOffset` is the
             * output index where the current hop's wire index 0 lands, and
             * both reset at every wire-open and seam — `emitReindexed` maps
             * wire index N to `hopOffset + N`.
             */
            private int $nextIndex = 0;

            /** @var list<array{from: string, to: string}> seams queued until the wire opens */
            private array $pendingSeams = [];

            /** @var array{start: array<string,mixed>|null, delta: array<string,mixed>, stop: array<string,mixed>}|null */
            private ?array $held = null;

            private bool $wireOpen = false;

            private bool $terminalSent = false;

            private bool $stopSent = false;

            private bool $done = false;

            // ── per-hop state (reset on engage) ──
            private bool $isRetryHop = false;

            private bool $contentSeen = false;

            private bool $sawSeam = false;

            private string $effModel;

            /** the engaged entry's model — unlike effModel, server seams never overwrite it */
            private string $hopModel;

            /** @var array<string,mixed>|null the current hop's held message_start event data */
            private ?array $startRaw = null;

            /** @var array<int,true> blocks the current hop has open */
            private array $open = [];

            /** @var array<int,array<string,mixed>> raw accumulated blocks by wire index */
            private array $blocks = [];

            /** @var list<int> wire indices in arrival order */
            private array $blockOrder = [];

            private int $hopOffset = 0;

            private SseDecoder $decoder;

            private string $out = '';

            /** @var callable(array<string,mixed>): ResponseInterface */
            private $send;

            /** @var callable(int,mixed): void */
            private $onHop;

            /**
             * @param array<string,mixed> $body the original request body,
             *                                  already armed/scrubbed by the middleware
             * @param list<array<string,mixed>> $fallbacks
             * @param int $next index of the first chain entry a refusal would try
             * @param callable(array<string,mixed>): ResponseInterface $send issues one armed hop request through the chain
             * @param callable(int,mixed): void $onHop pin + onFallback bookkeeping, called as each hop is attempted
             */
            public function __construct(
                ResponseInterface $response,
                private array $body,
                private readonly array $fallbacks,
                private int $next,
                callable $send,
                callable $onHop,
            ) {
                $model = $this->body['model'] ?? '';
                $this->effModel = is_string($model) ? $model : '';
                $this->hopModel = $this->effModel;
                $this->decoder = new SseDecoder($response->getBody());
                $this->send = $send;
                $this->onHop = $onHop;
            }

            /**
             * Pulls the next chunk of spliced SSE bytes; null at end of stream.
             */
            public function close(): void
            {
                $this->done = true;
                $this->decoder->close();
            }

            public function read(): ?string
            {
                while ('' === $this->out && !$this->done) {
                    $this->advance();
                }

                if ('' !== $this->out) {
                    $chunk = $this->out;
                    $this->out = '';

                    return $chunk;
                }

                return null;
            }

            private function advance(): void
            {
                $event = $this->decoder->next();

                if (is_null($event)) {
                    if ($this->isRetryHop && !$this->terminalSent && !$this->contentSeen && [] !== $this->pendingSeams) {
                        // the hop's stream ended without engaging — no content, no
                        // terminal: a failed hop. Its queued seam is dropped and the
                        // walk continues to the next entry or the degrade.
                        array_pop($this->pendingSeams);
                        $this->openNextHop();

                        return;
                    }
                    // the hop's wire ended without dispatching message_stop (an
                    // unterminated final frame); the spliced stream still completes
                    if ($this->terminalSent && !$this->stopSent) {
                        $this->emit('message_stop', ['type' => 'message_stop']);
                        $this->stopSent = true;
                    }
                    $this->done = true;

                    return;
                }

                [$type, $data] = $event;
                if ('message_stop' === $type) {
                    $this->stopSent = true;
                }

                switch ($type) {
                    case 'ping':
                        // dropped: a held message_start must stay the first event out
                        break;

                    case 'message_start':
                        $this->startRaw = $data;
                        if (!$this->isRetryHop) {
                            $message = $data['message'] ?? null;
                            $id = is_array($message) ? ($message['id'] ?? null) : null;
                            $this->primaryID = is_string($id) ? $id : '';
                        }

                        break;

                    case 'content_block_start':
                        $this->ensureWireOpen();
                        $this->contentSeen = true;
                        $index = self::int($data['index'] ?? null);
                        $this->open[$index] = true;
                        $block = is_array($data['content_block'] ?? null) ? $data['content_block'] : [];
                        $this->blocks[$index] = ['start' => $block, 'text' => '', 'thinking' => '', 'signature' => '', 'partial_json' => '', 'citations' => []];
                        $this->blockOrder[] = $index;
                        if ('fallback' === ($block['type'] ?? null)) {
                            $this->sawSeam = true;
                            $to = is_array($block['to'] ?? null) ? ($block['to']['model'] ?? null) : null;
                            $this->effModel = is_string($to) ? $to : $this->effModel;
                        }
                        $this->emitReindexed($type, data: $data, wireIndex: $index);

                        break;

                    case 'content_block_delta':
                        $this->ensureWireOpen();
                        $this->contentSeen = true;
                        $index = self::int($data['index'] ?? null);
                        $delta = self::stringKeys(is_array($data['delta'] ?? null) ? $data['delta'] : []);
                        $this->foldDelta($index, delta: $delta);
                        $this->emitReindexed($type, data: $data, wireIndex: $index);

                        break;

                    case 'content_block_stop':
                        $this->ensureWireOpen();
                        $this->contentSeen = true;
                        $index = self::int($data['index'] ?? null);
                        unset($this->open[$index]);
                        $this->emitReindexed($type, data: $data, wireIndex: $index);

                        break;

                    case 'message_delta':
                        $this->handleTerminal($data);

                        break;

                    default:
                        if ('message_stop' === $type && $this->isRetryHop && !$this->terminalSent) {
                            // a hop's stop rides only behind its terminal; a dead
                            // hop's bare stop never leaks into the splice
                            break;
                        }
                        $this->emit($type, $data);
                }
            }

            /** @param array<string,mixed> $data */
            private function handleTerminal(array $data): void
            {
                $delta = is_array($data['delta'] ?? null) ? $data['delta'] : [];
                $refused = 'refusal' === ($delta['stop_reason'] ?? null);

                if (!$refused) {
                    $this->ensureWireOpen();
                    $this->terminalSent = true;
                    $this->emit('message_delta', $this->isRetryHop ? $this->rewriteTerminal($data, stampNullIfAbsent: false) : $data);

                    return;
                }

                $details = is_array($delta['stop_details'] ?? null) ? $delta['stop_details'] : [];
                $token = $details['fallback_credit_token'] ?? null;
                $token = is_string($token) ? $token : '';

                // a token is required once content has streamed; a pre-stream
                // refusal retries free — nothing reached the consumer
                $canRetry = '' !== $token || !$this->contentSeen;

                if ($this->next < count($this->fallbacks) && $canRetry) {
                    $this->ledger = [...$this->ledger, ...$this->hopIterations($data, final: false)];
                    $this->lastClaimCount = 0;
                    if (true === ($details['fallback_has_prefill_claim'] ?? null)) {
                        $claim = $this->claimBlocks();
                        $this->continuation = [...$this->continuation, ...$claim];
                        $this->lastClaimCount = count($claim);
                    }
                    $this->token = $token;
                    $this->held = ['start' => $this->startRaw, 'delta' => $data, 'stop' => $this->readAheadStop()];
                    // blocks the refusal cut open close NOW, so both the engaged
                    // splice and a later degrade land on complete framing
                    $this->closeOpenBlocks();
                    $this->openNextHop();

                    return;
                }

                $this->ensureWireOpen();
                $this->terminalSent = true;
                $this->emit('message_delta', $this->isRetryHop ? $this->rewriteTerminal($data, stampNullIfAbsent: true) : $data);
            }

            private function openNextHop(): void
            {
                $lastStatus = 0;
                $attempts = 0;

                $heldStart = $this->held['start'] ?? null;
                $refused = is_array($heldStart) ? ($heldStart['message'] ?? null) : null;

                /** @var array<string,mixed>|null $lastEntry */
                $lastEntry = null;
                while ($this->next < count($this->fallbacks)) {
                    $entry = $this->fallbacks[$this->next];
                    if (($entry['model'] ?? null) === $this->hopModel) {
                        // never re-ask the model that just refused — by model, not
                        // index: the server 400s same-model redemptions
                        ++$this->next;

                        continue;
                    }
                    ($this->onHop)($this->next, $refused);
                    ++$this->next;
                    ++$attempts;

                    [$response, $lastStatus] = $this->tryHop($entry, continuation: $this->continuation);
                    if (!is_null($response)) {
                        $this->engageWith($response, entry: $entry, continuation: $this->continuation);

                        return;
                    }
                    $lastEntry = $entry;
                }

                // The blanket redemption ladder (gaveled 2026-06-07): a 400 on the
                // hop performing the refusal retry walks replacement redemption
                // forms on the SAME entry - drop the claim turn (token kept), then
                // drop the token. Walked at most once per refusal; a 400 on a LATER
                // entry after hops were skipped is an ordinary hop failure.
                if (400 === $lastStatus && 1 === $attempts && !is_null($lastEntry)) {
                    $trimmed = $this->lastClaimCount > 0
                        ? array_slice($this->continuation, offset: 0, length: count($this->continuation) - $this->lastClaimCount)
                        : $this->continuation;

                    if ($this->lastClaimCount > 0) {
                        [$response, $lastStatus] = $this->tryHop($lastEntry, continuation: $trimmed);
                        if (!is_null($response)) {
                            $this->engageWith($response, entry: $lastEntry, continuation: $trimmed);

                            return;
                        }
                    }

                    if (400 === $lastStatus && '' !== $this->token) {
                        // the reprice is lost; this leg is the only one allowed to
                        // drop fallback_credit_token
                        $this->token = '';
                        [$response, $lastStatus] = $this->tryHop($lastEntry, continuation: $trimmed);
                        if (!is_null($response)) {
                            $this->engageWith($response, entry: $lastEntry, continuation: $trimmed);

                            return;
                        }
                    }
                }

                $this->degrade($lastStatus, lastEntry: $lastEntry);
            }

            /**
             * Issues one hop attempt; a null response means the hop failed over
             * HTTP at the returned status (0 for transport failures) — the token
             * and continuation carry unchanged to the next entry, and no seam is
             * emitted for a hop that never engaged.
             *
             * @param array<string,mixed> $entry
             * @param list<mixed> $continuation
             *
             * @return array{ResponseInterface|null, int}
             */
            private function tryHop(array $entry, array $continuation): array
            {
                $body = RefusalFallbackMiddleware::mergeEntry($this->body, entry: $entry);
                unset($body['fallbacks'], $body['fallback'], $body['fallback_credit_token']);
                if ('' !== $this->token) {
                    $body['fallback_credit_token'] = $this->token;
                }
                if ([] !== $continuation) {
                    $messages = is_array($body['messages'] ?? null) ? $body['messages'] : [];
                    $messages[] = ['role' => 'assistant', 'content' => $continuation];
                    $body['messages'] = $messages;
                }

                try {
                    $response = ($this->send)($body);
                } catch (ClientExceptionInterface) {
                    return [null, 0];
                }

                if (!RefusalFallbackMiddleware::isEventStream($response)) {
                    $status = $response->getStatusCode();
                    $response->getBody()->close();

                    return [null, $status];
                }

                return [$response, $response->getStatusCode()];
            }

            /** @param array<string,mixed> $entry */
            private function engage(ResponseInterface $response, array $entry): void
            {
                $to = $entry['model'] ?? '';
                $seam = ['from' => $this->effModel, 'to' => is_string($to) ? $to : ''];

                // The seam is queued, not emitted: it reaches the wire only once
                // the hop proves itself with real output. A hop whose stream dies
                // without engaging leaves no seam (its entry is popped instead).
                $this->pendingSeams[] = $seam;

                $this->isRetryHop = true;
                $this->contentSeen = false;
                $this->stopSent = false;
                $this->sawSeam = false;
                $this->effModel = $seam['to'];
                $this->hopModel = $seam['to'];
                $this->open = [];
                $this->blocks = [];
                $this->blockOrder = [];
                $this->startRaw = null;
                $this->decoder->close();
                $this->decoder = new SseDecoder($response->getBody());
            }

            /**
             * Engages a hop's live stream, committing the continuation the attempt
             * was made with; an engaged hop's claim accounting is settled.
             *
             * @param array<string,mixed> $entry
             * @param list<mixed> $continuation
             */
            private function engageWith(ResponseInterface $response, array $entry, array $continuation): void
            {
                $this->continuation = $continuation;
                $this->lastClaimCount = 0;
                $this->engage($response, entry: $entry);
            }

            /**
             * @param array<mixed> $values
             *
             * @return array<string,mixed>
             */
            private static function stringKeys(array $values): array
            {
                $out = [];
                foreach ($values as $k => $v) {
                    $out[strval($k)] = $v;
                }

                return $out;
            }

            /** @param array<string,mixed>|null $lastEntry */
            private function degrade(int $lastStatus, ?array $lastEntry): void
            {
                $held = $this->held;
                if (is_null($held)) {
                    $this->done = true;

                    return;
                }

                // startRaw still holds the refused hop's start here (engage() only
                // clears it for a hop that engaged), so the one wire-opening path
                // serves the degrade too.
                $this->ensureWireOpen();

                $data = $held['delta'];
                $delta = is_array($data['delta'] ?? null) ? $data['delta'] : [];
                $details = is_array($delta['stop_details'] ?? null) ? $delta['stop_details'] : [];

                // the last failed entry's model on a 429, null otherwise; a non-null
                // wire value wins
                if (!array_key_exists('recommended_model', $details) || is_null($details['recommended_model'])) {
                    $lastModel = $lastEntry['model'] ?? null;
                    $details['recommended_model'] = 429 === $lastStatus && is_string($lastModel) ? $lastModel : null;
                    $delta['stop_details'] = $details;
                    $data['delta'] = $delta;
                }

                if ([] !== $this->ledger) {
                    $usage = is_array($data['usage'] ?? null) ? $data['usage'] : [];
                    $usage['iterations'] = $this->ledger;
                    $data['usage'] = $usage;
                }

                $this->emit('message_delta', $data);
                $this->emit('message_stop', $held['stop']);
                $this->done = true;
            }

            /**
             * Replaces the serving hop's `usage.iterations` with the whole-chain
             * ledger; on a surfaced retry-hop refusal also stamps a missing
             * `recommended_model` null.
             *
             * @param array<string,mixed> $data
             *
             * @return array<string,mixed>
             */
            private function rewriteTerminal(array $data, bool $stampNullIfAbsent): array
            {
                $usage = is_array($data['usage'] ?? null) ? $data['usage'] : [];
                $usage['iterations'] = [...$this->ledger, ...$this->hopIterations($data, final: true)];
                $data['usage'] = $usage;

                if ($stampNullIfAbsent) {
                    $delta = is_array($data['delta'] ?? null) ? $data['delta'] : [];
                    $details = is_array($delta['stop_details'] ?? null) ? $delta['stop_details'] : [];
                    if (!array_key_exists('recommended_model', $details)) {
                        $details['recommended_model'] = null;
                        $delta['stop_details'] = $details;
                        $data['delta'] = $delta;
                    }
                }

                return $data;
            }

            /**
             * One hop's ledger contribution: the wire's own iterations verbatim when
             * reported, else one entry synthesized from the delta's usage.
             *
             * @param array<string,mixed> $data
             *
             * @return list<array<string,mixed>>
             */
            private function hopIterations(array $data, bool $final): array
            {
                $usage = is_array($data['usage'] ?? null) ? $data['usage'] : [];
                $reported = is_array($usage['iterations'] ?? null) ? array_values($usage['iterations']) : [];

                /** @var list<array<string,mixed>> $entries */
                $entries = [];
                if ([] !== $reported) {
                    foreach ($reported as $entry) {
                        $entries[] = self::stringKeys(is_array($entry) ? $entry : []);
                    }
                } else {
                    $entries[] = [
                        'type' => 'message',
                        'input_tokens' => $usage['input_tokens'] ?? 0,
                        'output_tokens' => $usage['output_tokens'] ?? 0,
                        'cache_read_input_tokens' => $usage['cache_read_input_tokens'] ?? 0,
                        'cache_creation_input_tokens' => $usage['cache_creation_input_tokens'] ?? 0,
                        'cache_creation' => $usage['cache_creation'] ?? null,
                    ];
                }

                $count = count($entries);
                foreach ($entries as $i => $entry) {
                    $last = $i === $count - 1;
                    if ($final && $last) {
                        $entry['type'] = 'fallback_message';
                    } elseif ('fallback_message' === ($entry['type'] ?? null)) {
                        // the envelope's serving hop declined the overall request; it
                        // is an ordinary attempt in the merged ledger
                        $entry['type'] = 'message';
                    } elseif (!isset($entry['type']) || '' === $entry['type']) {
                        $entry['type'] = 'message';
                    }

                    // every entry in one hop's contribution belongs to that hop's
                    // requested model; stamp the ones the wire left unattributed
                    if (!isset($entry['model']) && '' !== $this->hopModel) {
                        $entry['model'] = $this->hopModel;
                    }
                    $entries[$i] = $entry;
                }

                return $entries;
            }

            /**
             * The refused hop's claimable partial: every accumulated block after its
             * last server seam, deltas folded back in.
             *
             * @return list<array<string,mixed>>
             */
            private function claimBlocks(): array
            {
                $finalized = [];
                foreach ($this->blockOrder as $index) {
                    $raw = $this->blocks[$index] ?? null;
                    if (is_null($raw)) {
                        continue;
                    }
                    $start = $raw['start'] ?? null;
                    if (is_array($start) && 'fallback' === ($start['type'] ?? null)) {
                        $finalized = []; // restart after the seam

                        continue;
                    }
                    $finalized[] = self::finalizeBlock($raw);
                }

                // The echoed partial's final text block is rstripped: the server's
                // claim hash canonicalizes with a trailing-whitespace strip on both
                // mint and redeem, and the API 400s a final assistant message that
                // ends in whitespace — the trimmed echo still redeems.
                if ([] !== $finalized) {
                    $last = $finalized[count($finalized) - 1];
                    if ('text' === ($last['type'] ?? null) && is_string($last['text'] ?? null)) {
                        $last['text'] = rtrim($last['text'], " \t\r\n");
                        $finalized[count($finalized) - 1] = $last;
                    }
                }

                return $finalized;
            }

            /**
             * @param array<string,mixed> $raw
             *
             * @return array<string,mixed>
             */
            private static function finalizeBlock(array $raw): array
            {
                $start = $raw['start'] ?? null;
                $block = self::stringKeys(is_array($start) ? $start : []);

                foreach (['text', 'thinking', 'signature'] as $field) {
                    $accumulated = self::str($raw[$field] ?? null);
                    if ('' !== $accumulated) {
                        $block[$field] = self::str($block[$field] ?? null).$accumulated;
                    }
                }

                $partial = self::str($raw['partial_json'] ?? null);
                if ('' !== $partial) {
                    $decoded = json_decode($partial, associative: true);
                    if (!is_null($decoded)) {
                        $block['input'] = $decoded;
                    }
                }

                $citations = is_array($raw['citations'] ?? null) ? $raw['citations'] : [];
                foreach ($citations as $citation) {
                    $existing = is_array($block['citations'] ?? null) ? $block['citations'] : [];
                    $existing[] = $citation;
                    $block['citations'] = $existing;
                }

                if (array_key_exists('compaction_content', $raw)) {
                    $block['content'] = self::str($block['content'] ?? null).self::str($raw['compaction_content']);
                }
                if (array_key_exists('compaction_encrypted', $raw)) {
                    $block['encrypted_content'] = $raw['compaction_encrypted'];
                }

                return $block;
            }

            /**
             * @param array<string,mixed> $raw
             * @param array<string,mixed> $delta
             *
             * @return array<string,mixed>
             */
            private static function foldCompaction(array $raw, array $delta): array
            {
                $raw['compaction_content'] = self::str($raw['compaction_content'] ?? null).self::str($delta['content'] ?? null);
                if (array_key_exists('encrypted_content', $delta)) {
                    $raw['compaction_encrypted'] = $delta['encrypted_content'];
                }

                return $raw;
            }

            /** @param array<string,mixed> $delta */
            private function foldDelta(int $index, array $delta): void
            {
                if (!isset($this->blocks[$index])) {
                    return;
                }
                $raw = $this->blocks[$index];

                match ($delta['type'] ?? null) {
                    'text_delta' => $raw['text'] = self::str($raw['text'] ?? null).self::str($delta['text'] ?? null),
                    'thinking_delta' => $raw['thinking'] = self::str($raw['thinking'] ?? null).self::str($delta['thinking'] ?? null),
                    'signature_delta' => $raw['signature'] = self::str($raw['signature'] ?? null).self::str($delta['signature'] ?? null),
                    'input_json_delta' => $raw['partial_json'] = self::str($raw['partial_json'] ?? null).self::str($delta['partial_json'] ?? null),
                    'citations_delta' => $raw['citations'] = [...(is_array($raw['citations'] ?? null) ? $raw['citations'] : []), $delta['citation'] ?? null],
                    // compaction content accumulates like the accumulator's fold —
                    // a claim that drops it can never match the mint-side hash
                    'compaction_delta' => $raw = self::foldCompaction($raw, delta: $delta),
                    default => null,
                };

                $this->blocks[$index] = $raw;
            }

            /**
             * Reads ahead on the refused stream for its message_stop (skipping
             * pings); synthesizes one when the wire ends or moves on.
             *
             * @return array<string,mixed>
             */
            private function readAheadStop(): array
            {
                while (true) {
                    $event = $this->decoder->next();
                    if (is_null($event)) {
                        break;
                    }
                    [$type, $data] = $event;
                    if ('ping' === $type) {
                        continue;
                    }

                    return 'message_stop' === $type ? $data : ['type' => 'message_stop'];
                }

                return ['type' => 'message_stop'];
            }

            private function ensureWireOpen(): void
            {
                if ($this->wireOpen) {
                    // the hop just produced real output: its queued seam commits
                    $this->flushPendingSeams();

                    return;
                }
                $this->wireOpen = true;

                $start = $this->startRaw;
                if (!is_null($start)) {
                    // the envelope keeps the primary's message id no matter which
                    // hop opens the wire (on the primary hop the stamp is a no-op:
                    // its start already carries primaryID)
                    if ('' !== $this->primaryID && is_array($start['message'] ?? null)) {
                        $start['message']['id'] = $this->primaryID;
                    }
                    $this->emit('message_start', $start);
                }

                $this->flushPendingSeams();
                $this->hopOffset = $this->nextIndex;
            }

            /** Emits queued seams; the next hop's wire indices follow them. */
            private function flushPendingSeams(): void
            {
                if ([] === $this->pendingSeams) {
                    return;
                }
                foreach ($this->pendingSeams as $seam) {
                    $this->emitSeam($seam);
                }
                $this->pendingSeams = [];
                $this->hopOffset = $this->nextIndex;
            }

            private function closeOpenBlocks(): void
            {
                $indices = array_keys($this->open);
                sort($indices);
                foreach ($indices as $index) {
                    $this->emit('content_block_stop', ['type' => 'content_block_stop', 'index' => $this->hopOffset + $index]);
                }
                $this->open = [];
            }

            /** @param array{from: string, to: string} $seam */
            private function emitSeam(array $seam): void
            {
                $index = $this->nextIndex;
                ++$this->nextIndex;

                $block = ['type' => 'fallback', 'from' => ['model' => $seam['from']], 'to' => ['model' => $seam['to']]];
                $this->emit('content_block_start', ['type' => 'content_block_start', 'index' => $index, 'content_block' => $block]);
                $this->emit('content_block_stop', ['type' => 'content_block_stop', 'index' => $index]);
                $this->hopOffset = $this->nextIndex;
            }

            /** @param array<string,mixed> $data */
            private function emitReindexed(string $type, array $data, int $wireIndex): void
            {
                $out = $this->hopOffset + $wireIndex;
                if ($out + 1 > $this->nextIndex) {
                    $this->nextIndex = $out + 1;
                }
                if ($out !== $wireIndex) {
                    $data['index'] = $out;
                }
                $this->emit($type, $data);
            }

            /** @param array<string,mixed> $data */
            private function emit(string $type, array $data): void
            {
                $encoded = json_encode($data, flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
                $this->out .= "event: {$type}\ndata: {$encoded}\n\n";
            }

            private static function str(mixed $value): string
            {
                return is_string($value) ? $value : '';
            }

            private static function int(mixed $value): int
            {
                return is_int($value) ? $value : (is_numeric($value) ? intval($value) : 0);
            }
        };

        // A read-only PSR-7 stream over the splice's pull. `read()` performs at
        // most one pull beyond its buffer and returns short: a consumer asking
        // for more bytes than are available gets what exists now rather than
        // waiting for the producer — which would buffer a whole streamed
        // response before the first byte reaches the app.
        $pullBody = new class(
            static fn (): ?string => $splicer->read(),
            static function () use ($splicer): void { $splicer->close(); },
        ) implements StreamInterface {
            private string $buffer = '';

            private bool $exhausted = false;

            private int $position = 0;

            /** @var (callable(): ?string)|null */
            private $pull;

            /** @var (callable(): void)|null */
            private $onClose;

            /**
             * @param callable(): ?string $pull returns the next chunk, or null
             *                                  at end of stream
             * @param callable(): void $onClose closes the splicer's upstream
             */
            public function __construct(callable $pull, callable $onClose)
            {
                $this->pull = $pull;
                $this->onClose = $onClose;
            }

            public function __toString(): string
            {
                try {
                    return $this->getContents();
                } catch (\Throwable) {
                    return '';
                }
            }

            public function read(int $length): string
            {
                if ($length <= 0 || $this->eof()) {
                    return '';
                }

                if ('' === $this->buffer) {
                    // close() sets exhausted before nulling pull, so pull is
                    // non-null past the eof() guard
                    $pull = $this->pull;
                    $chunk = is_null($pull) ? null : $pull();
                    if (is_null($chunk)) {
                        $this->exhausted = true;
                    } else {
                        $this->buffer = $chunk;
                    }
                }

                $out = substr($this->buffer, offset: 0, length: $length);
                $this->buffer = substr($this->buffer, offset: strlen($out));
                $this->position += strlen($out);

                return $out;
            }

            public function eof(): bool
            {
                return $this->exhausted && '' === $this->buffer;
            }

            public function getContents(): string
            {
                $contents = '';
                while (!$this->eof()) {
                    $chunk = $this->read(8192);
                    if ('' === $chunk) {
                        break; // read() returns short only at end of stream
                    }
                    $contents .= $chunk;
                }

                return $contents;
            }

            public function close(): void
            {
                $this->exhausted = true;
                $this->buffer = '';
                $this->pull = null;
                if (null !== $this->onClose) {
                    ($this->onClose)();
                    $this->onClose = null;
                }
            }

            public function detach()
            {
                $this->close();

                return null;
            }

            public function getSize(): ?int
            {
                return null;
            }

            public function tell(): int
            {
                return $this->position;
            }

            public function isSeekable(): bool
            {
                return false;
            }

            public function seek(int $offset, int $whence = SEEK_SET): void
            {
                throw new \RuntimeException('pull stream is not seekable');
            }

            public function rewind(): void
            {
                throw new \RuntimeException('pull stream is not seekable');
            }

            public function isWritable(): bool
            {
                return false;
            }

            public function write(string $string): int
            {
                throw new \RuntimeException('pull stream is not writable');
            }

            public function isReadable(): bool
            {
                return true;
            }

            public function getMetadata(?string $key = null)
            {
                return is_null($key) ? [] : null;
            }
        };

        return $response
            ->withBody($pullBody)
            ->withoutHeader('Content-Length')
        ;
    }

    /**
     * Detects a terminal refusal: only 200s with an already-decoded body
     * count; anything else is final. Returns the (possibly re-buffered)
     * response alongside the parsed message and minted credit token, or null
     * when there is nothing to retry.
     *
     * @return array{ResponseInterface, array{mixed,string|null}|null}
     */
    private function refusal(
        ResponseInterface $response
    ): array {
        if (200 !== $response->getStatusCode() || '' !== $response->getHeaderLine('Content-Encoding')) {
            return [$response, null];
        }

        [$message, $response] = $this->parseResponseBody($response);
        if ('refusal' !== self::field($message, property: 'stopReason', key: 'stop_reason')) {
            return [$response, null];
        }

        $details = self::field($message, property: 'stopDetails', key: 'stop_details');
        $token = self::field($details, property: 'fallbackCreditToken', key: 'fallback_credit_token');

        return [$response, [$message, is_string($token) ? $token : null]];
    }

    /**
     * Strips fallback seam blocks from assistant history: they are
     * parse-gated behind the server-side fallback beta, which is
     * caller-owned and never sent by this middleware. History is not
     * consulted for pinning — explicit-state pinning only.
     *
     * @param array<string,mixed> $body
     *
     * @return array<string,mixed>
     */
    private static function withoutSeamBlocks(array $body, bool $scrubOrphans = false): array
    {
        $messages = $body['messages'] ?? null;
        if (!is_array($messages)) {
            return $body;
        }

        // every tool_use id a tool_result anywhere resolves
        $resolved = [];
        if ($scrubOrphans) {
            foreach ($messages as $message) {
                $message = self::bodyArray($message);
                $content = is_array($message['content'] ?? null) ? $message['content'] : [];
                foreach ($content as $block) {
                    $block = self::bodyArray($block);
                    if ('tool_result' === ($block['type'] ?? null) && is_string($block['tool_use_id'] ?? null)) {
                        $resolved[$block['tool_use_id']] = true;
                    }
                }
            }
        }

        foreach ($messages as $i => $message) {
            $message = self::bodyArray($message);
            if (is_null($message) || 'assistant' !== ($message['role'] ?? null) || !is_array($message['content'] ?? null)) {
                continue;
            }

            $hasSeam = false;
            foreach ($message['content'] as $block) {
                if ('fallback' === (self::bodyArray($block)['type'] ?? null)) {
                    $hasSeam = true;

                    break;
                }
            }
            if (!$hasSeam) {
                continue; // turns without a seam belong to the caller
            }

            $message['content'] = array_values(array_filter(
                $message['content'],
                static function ($block) use ($scrubOrphans, $resolved): bool {
                    $block = self::bodyArray($block);
                    if ('fallback' === ($block['type'] ?? null)) {
                        return false;
                    }
                    if ($scrubOrphans && 'tool_use' === ($block['type'] ?? null)) {
                        $id = $block['id'] ?? null;

                        return is_string($id) && isset($resolved[$id]);
                    }

                    return true;
                },
            ));
            // A turn that carried only seam blocks vanishes entirely — an
            // empty assistant turn would fail validation when echoed.
            $messages[$i] = [] === $message['content'] ? null : $message;
        }

        $body['messages'] = array_values(array_filter($messages, static fn ($m) => null !== $m));

        return $body;
    }

    /**
     * Arms the credit beta — minting and redemption are gated behind it, and
     * the middleware arms every leg it handles, deduping caller-set values.
     */
    private static function withCreditBeta(RequestInterface $request): RequestInterface
    {
        $flag = AnthropicBeta::FALLBACK_CREDIT_2026_06_01->value;

        $existing = $request->getHeaderLine('anthropic-beta');
        $values = '' === $existing ? [] : array_map('trim', explode(',', $existing));
        if (!in_array($flag, $values, strict: true)) {
            $values[] = $flag;
        }

        return $request->withHeader('anthropic-beta', implode(',', $values));
    }

    /**
     * Tags every leg the middleware sends with the fallback helper telemetry
     * value, appended to whatever `x-stainless-helper` already carries so it
     * composes with other helper tags.
     */
    private static function withHelperTag(RequestInterface $request): RequestInterface
    {
        return $request->withHeader(
            StainlessHelperHeader::HEADER,
            StainlessHelperHeader::mergedValue(
                [StainlessHelperHeader::HEADER => $request->getHeaderLine(StainlessHelperHeader::HEADER)],
                StainlessHelperHeader::FALLBACK_REFUSAL_MIDDLEWARE,
            ),
        );
    }

    /**
     * Prepends fallback seam blocks to a served message body, mirroring the
     * envelope the server-side fallback chain would have returned. Bodies
     * that don't decode to a message with list content pass through.
     *
     * @param list<array<string,mixed>> $seams
     * @param list<array<string,mixed>> $ledger
     */
    private function withSeamsPrepended(
        ResponseInterface $response,
        array $seams,
        array $ledger,
        ?string $servingModel
    ): ResponseInterface {
        $raw = (string) $response->getBody();
        $decoded = json_decode($raw, associative: true);
        if (!is_array($decoded) || !is_array($decoded['content'] ?? null) || !array_is_list($decoded['content'])) {
            return $response;
        }

        $decoded['content'] = [...$seams, ...$decoded['content']];

        // The stitched envelope's usage carries the whole-chain ledger:
        // every refused hop as a `message` entry, the serving hop appended
        // as the `fallback_message` completer — mirroring the streaming
        // splice. A terminal refusal stays verbatim, ledger and all.
        if ([] !== $ledger && 'refusal' !== ($decoded['stop_reason'] ?? null)) {
            $usage = is_array($decoded['usage'] ?? null) ? $decoded['usage'] : [];
            $usage['iterations'] = [
                ...$ledger,
                self::iterationEntry($decoded, type: 'fallback_message', model: $servingModel),
            ];
            $decoded['usage'] = $usage;
        }

        $encoded = json_encode($decoded, flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

        return $response
            ->withBody($this->streamFactory->createStream($encoded))
            ->withoutHeader('Content-Length')
        ;
    }

    /** @param array<string,mixed> $body */
    private function withBody(
        RequestInterface $request,
        array $body
    ): RequestInterface {
        return Util::withSetBody($this->streamFactory, req: $request, body: $body);
    }

    /**
     * Decodes the outgoing request body to its wire-shape array, restoring
     * the stream so the rest of the pipeline can read it again. A
     * non-seekable body is left untouched — the SDK always builds seekable
     * bodies, so this is a stand-down guard.
     */
    private function requestBody(RequestInterface $request): mixed
    {
        $stream = $request->getBody();
        if (!$stream->isSeekable()) {
            return null;
        }
        $stream->rewind();
        $raw = $stream->getContents();
        $stream->rewind();
        if ('' === $raw) {
            return null;
        }

        return json_decode($raw, associative: true);
    }

    /**
     * Decodes a response body to an array the way the refusal detector reads
     * it. A seekable body is rewound in place; a non-seekable one is buffered
     * into a fresh seekable stream so the same bytes can be served onward.
     *
     * @return array{mixed, ResponseInterface}
     */
    private function parseResponseBody(ResponseInterface $response): array
    {
        $stream = $response->getBody();
        if ($stream->isSeekable()) {
            $stream->rewind();
        }
        $raw = $stream->getContents();
        if ($stream->isSeekable()) {
            $stream->rewind();
        } else {
            $response = $response->withBody($this->streamFactory->createStream($raw));
        }

        return [json_decode($raw, associative: true), $response];
    }

    /**
     * Reads a field off an SDK-typed model or a plain decoded array — mock
     * transports and error paths can surface either. SDK models are read via
     * their ArrayAccess interface, which tolerates absent keys where the
     * property accessor throws.
     */
    private static function field(mixed $value, string $property, string $key): mixed
    {
        if (is_array($value)) {
            return $value[$key] ?? $value[$property] ?? null;
        }

        if ($value instanceof \ArrayAccess) {
            foreach ([$property, $key] as $offset) {
                if ($value->offsetExists($offset)) {
                    return $value->offsetGet($offset);
                }
            }

            return null;
        }

        if (is_object($value)) {
            $vars = get_object_vars($value);

            return $vars[$property] ?? $vars[$key] ?? null;
        }

        return null;
    }

    /**
     * Normalizes a decoded body, message, or block to a string-keyed array.
     *
     * @return array<string,mixed>|null
     */
    private static function bodyArray(mixed $value): ?array
    {
        if (is_object($value)) {
            $value = get_object_vars($value);
        }
        if (!is_array($value)) {
            return null;
        }

        $out = [];
        foreach ($value as $k => $v) {
            if (!is_string($k)) {
                return null;
            }
            $out[$k] = $v;
        }

        return $out;
    }
}

/**
 * Incremental SSE decoder over a PSR stream: dispatches `[type, data]`
 * pairs, joining multi-line data with newlines; only `event`/`data` fields
 * are honored. Comment lines and other fields are ignored.
 *
 * @internal plumbing for the per-stream splice
 */
final class SseDecoder
{
    private string $buffer = '';

    private bool $eof = false;

    public function __construct(private readonly StreamInterface $stream) {}

    public function close(): void
    {
        $this->eof = true;
        $this->stream->close();
    }

    /** @return array{string,array<string,mixed>}|null */
    public function next(): ?array
    {
        $type = '';
        $data = '';

        while (true) {
            $line = $this->readLine();
            if (is_null($line)) {
                return null; // an unterminated final frame is not dispatched
            }

            if ('' === $line) {
                if ('' === $data && '' === $type) {
                    continue; // stray blank line
                }
                $decoded = json_decode($data, associative: true);
                $payload = [];
                if (is_array($decoded)) {
                    foreach ($decoded as $k => $v) {
                        $payload[strval($k)] = $v;
                    }
                }
                $payloadType = $payload['type'] ?? null;
                $eventType = '' !== $type ? $type : (is_string($payloadType) ? $payloadType : '');

                return [$eventType, $payload];
            }

            if (str_starts_with($line, ':')) {
                continue; // comment
            }

            $name = $line;
            $value = '';
            if (str_contains($line, ':')) {
                [$name, $value] = explode(':', $line, limit: 2);
                if (str_starts_with($value, ' ')) {
                    $value = substr($value, 1);
                }
            }

            if ('event' === $name) {
                $type = $value;
            } elseif ('data' === $name) {
                $data .= $value."\n";
            }
        }
    }

    private function readLine(): ?string
    {
        while (true) {
            $pos = strpos($this->buffer, "\n");
            if (false !== $pos) {
                $line = substr($this->buffer, offset: 0, length: $pos);
                $this->buffer = substr($this->buffer, offset: $pos + 1);

                return rtrim($line, "\r");
            }

            if ($this->eof) {
                return null;
            }

            if ($this->stream->eof()) {
                $this->eof = true;

                continue;
            }
            $chunk = $this->stream->read(8192);
            if ('' === $chunk) {
                $this->eof = true;
            }
            $this->buffer .= $chunk;
        }
    }
}
