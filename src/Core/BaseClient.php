<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Anthropic\Core\Contracts\BasePage;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\RequestOptions;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * @phpstan-type normalized_request = array{
 *   method: string,
 *   path: string,
 *   query: array<string,mixed>,
 *   headers: array<string,string|null|list<string>>,
 *   body: mixed,
 * }
 */
abstract class BaseClient
{
    protected UriInterface $baseUrl;

    /**
     * @internal
     *
     * @param array<string,string|int|list<string|int>|null> $headers
     */
    public function __construct(
        protected array $headers,
        string $baseUrl,
        protected RequestOptions $options = new RequestOptions,
    ) {
        assert(!is_null($this->options->uriFactory));
        $this->baseUrl = $this->options->uriFactory->createUri($baseUrl);
    }

    /**
     * @param string|list<mixed> $path
     * @param array<string,mixed> $query
     * @param array<string,mixed> $headers
     * @param class-string<BasePage<mixed>> $page
     * @param class-string<BaseStream<mixed>> $stream
     * @param RequestOptions|array<string,mixed>|null $options
     */
    public function request(
        string $method,
        string|array $path,
        array $query = [],
        array $headers = [],
        mixed $body = null,
        string|Converter|ConverterSource|null $convert = null,
        ?string $page = null,
        ?string $stream = null,
        RequestOptions|array|null $options = [],
    ): mixed {
        // @phpstan-ignore-next-line
        [$req, $opts] = $this->buildRequest(method: $method, path: $path, query: $query, headers: $headers, body: $body, opts: $options);
        ['method' => $method, 'path' => $uri, 'headers' => $headers] = $req;
        assert(!is_null($opts->requestFactory));

        $request = $opts->requestFactory->createRequest($method, uri: $uri);
        $request = Util::withSetHeaders($request, headers: $headers);

        // @phpstan-ignore-next-line
        $rsp = $this->sendRequest($opts, req: $request, data: $body, redirectCount: 0, retryCount: 0);

        if (!is_null($stream)) {
            return new $stream(
                convert: $convert,
                request: $request,
                response: $rsp
            );
        }

        if (!is_null($page)) {
            return new $page(
                convert: $convert,
                client: $this,
                request: $req,
                response: $rsp,
                options: $opts,
            );
        }

        if (!is_null($convert)) {
            return Conversion::coerceResponse($convert, response: $rsp);
        }

        return Util::decodeContent($rsp);
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [...$this->apiKeyAuth(), ...$this->bearerAuth()];
    }

    /** @return array<string,string> */
    abstract protected function apiKeyAuth(): array;

    /** @return array<string,string> */
    abstract protected function bearerAuth(): array;

    protected function getNormalizedOS(): string
    {
        $os = strtolower(PHP_OS_FAMILY);

        switch ($os) {
            case 'windows':
                return 'Windows';

            case 'darwin':
                return 'MacOS';

            case 'linux':
                return 'Linux';

            case 'bsd':
            case 'freebsd':
            case 'openbsd':
                return 'BSD';

            case 'solaris':
                return 'Solaris';

            case 'unix':
            case 'unknown':
                return 'Unknown';

            default:
                return 'Other:'.$os;
        }
    }

    protected function getNormalizedArchitecture(): string
    {
        $arch = php_uname('m');
        if (false !== strpos($arch, 'x86_64') || false !== strpos($arch, 'amd64')) {
            return 'x64';
        }
        if (false !== strpos($arch, 'i386') || false !== strpos($arch, 'i686')) {
            return 'x32';
        }
        if (false !== strpos($arch, 'aarch64') || false !== strpos($arch, 'arm64')) {
            return 'arm64';
        }
        if (false !== strpos($arch, 'arm')) {
            return 'arm';
        }

        return 'unknown';
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param array{
     *   timeout?: float|null,
     *   maxRetries?: int|null,
     *   initialRetryDelay?: float|null,
     *   maxRetryDelay?: float|null,
     *   extraHeaders?: array<string,string|int|list<string|int>|null>|null,
     *   extraQueryParams?: array<string,mixed>|null,
     *   extraBodyParams?: mixed,
     *   transporter?: ClientInterface|null,
     *   uriFactory?: UriFactoryInterface|null,
     *   streamFactory?: StreamFactoryInterface|null,
     *   requestFactory?: RequestFactoryInterface|null,
     * }|null $opts
     *
     * @return array{normalized_request, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        $options = RequestOptions::parse($this->options, $opts);

        $parsedPath = Util::parsePath($path);

        /** @var array<string,mixed> $mergedQuery */
        $mergedQuery = array_merge_recursive(
            $query,
            $options->extraQueryParams ?? [],
        );
        $uri = Util::joinUri($this->baseUrl, path: $parsedPath, query: $mergedQuery)->__toString();

        /** @var array<string,string|list<string>|null> $mergedHeaders */
        $mergedHeaders = [...$this->headers,
            ...$this->authHeaders(),
            ...$headers,
            ...($options->extraHeaders ?? []), ];

        $req = ['method' => strtoupper($method), 'path' => $uri, 'query' => $mergedQuery, 'headers' => $mergedHeaders, 'body' => $body];

        return [$req, $options];
    }

    /**
     * @internal
     */
    protected function followRedirect(
        ResponseInterface $rsp,
        RequestInterface $req
    ): RequestInterface {
        $location = $rsp->getHeaderLine('Location');
        if (!$location) {
            throw new APIConnectionException($req, message: 'Redirection without Location header');
        }

        $uri = Util::joinUri($req->getUri(), path: $location);

        return $req->withUri($uri);
    }

    /**
     * @internal
     */
    protected function shouldRetry(
        RequestOptions $opts,
        int $retryCount,
        ?ResponseInterface $rsp
    ): bool {
        if ($retryCount >= $opts->maxRetries) {
            return false;
        }

        $code = $rsp?->getStatusCode();
        if (408 == $code || 409 == $code || 429 == $code || $code >= 500) {
            return true;
        }

        return false;
    }

    /**
     * @internal
     */
    protected function retryDelay(
        RequestOptions $opts,
        int $retryCount,
        ?ResponseInterface $rsp
    ): float {
        if (!empty($header = $rsp?->getHeaderLine('retry-after'))) {
            if (is_numeric($header)) {
                return floatval($header);
            }

            try {
                $date = new \DateTimeImmutable($header);
                $span = time() - $date->getTimestamp();

                return max(0.0, $span);
            } catch (\DateMalformedStringException) {
            }
        }

        $scale = $retryCount ** 2;
        $jitter = 1 - (0.25 * mt_rand() / mt_getrandmax());
        $naive = $opts->initialRetryDelay * $scale * $jitter;

        return max(0.0, min($naive, $opts->maxRetryDelay));
    }

    /**
     * @internal
     *
     * @param bool|int|float|string|resource|\Traversable<mixed,>|array<string,mixed>|null $data
     */
    protected function sendRequest(
        RequestOptions $opts,
        RequestInterface $req,
        mixed $data,
        int $retryCount,
        int $redirectCount,
    ): ResponseInterface {
        assert(null !== $opts->streamFactory && null !== $opts->transporter);

        /** @var RequestInterface */
        $req = $req->withHeader('X-Stainless-Retry-Count', strval($retryCount));
        $req = Util::withSetBody($opts->streamFactory, req: $req, body: $data);

        $rsp = null;
        $err = null;

        try {
            $rsp = $opts->transporter->sendRequest($req);
        } catch (ClientExceptionInterface $e) {
            $err = $e;
        }

        $code = $rsp?->getStatusCode();

        if ($code >= 300 && $code < 400) {
            assert(!is_null($rsp));

            if ($redirectCount >= 20) {
                throw new APIConnectionException($req, message: 'Maximum redirects exceeded');
            }

            $req = $this->followRedirect($rsp, req: $req);

            return $this->sendRequest($opts, req: $req, data: $data, retryCount: $retryCount, redirectCount: ++$redirectCount);
        }

        if ($code >= 400 || is_null($rsp)) {
            if (!$this->shouldRetry($opts, retryCount: $retryCount, rsp: $rsp)) {
                $exn = is_null($rsp) ? new APIConnectionException($req, previous: $err) : APIStatusException::from(request: $req, response: $rsp);

                throw $exn;
            }

            $seconds = $this->retryDelay($opts, retryCount: $redirectCount, rsp: $rsp);
            $floor = floor($seconds);
            time_nanosleep((int) $floor, nanoseconds: (int) ($seconds - $floor) * 10 ** 9);

            return $this->sendRequest($opts, req: $req, data: $data, retryCount: ++$retryCount, redirectCount: $redirectCount);
        }

        return $rsp;
    }
}
