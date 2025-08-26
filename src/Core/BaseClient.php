<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Anthropic\Core\Contracts\BasePage;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Errors\APIStatusError;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
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
 *   query: array<string, mixed>,
 *   headers: array<string, string|null|list<string>>,
 *   body: mixed,
 * }
 */
class BaseClient
{
    protected UriInterface $baseUrl;

    protected UriFactoryInterface $uriFactory;

    protected StreamFactoryInterface $streamFactory;

    protected RequestFactoryInterface $requestFactory;

    protected ClientInterface $transporter;

    /**
     * @param array<string, string|int|list<string|int>|null> $headers
     */
    public function __construct(
        protected array $headers,
        string $baseUrl,
        protected RequestOptions $options = new RequestOptions,
    ) {
        $this->uriFactory = Psr17FactoryDiscovery::findUriFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();

        $this->baseUrl = $this->uriFactory->createUri($baseUrl);
        $this->transporter = Psr18ClientDiscovery::find();
    }

    /**
     * @param string|list<mixed> $path
     * @param array<string, mixed> $query
     * @param array<string, mixed> $headers
     * @param class-string<BasePage<mixed>> $page
     * @param class-string<BaseStream<mixed>> $stream
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
        mixed $options = [],
    ): mixed {
        // @phpstan-ignore-next-line
        [$req, $opts] = $this->buildRequest(method: $method, path: $path, query: $query, headers: $headers, body: $body, opts: $options);
        ['method' => $method, 'path' => $uri, 'headers' => $headers] = $req;

        $req = $this->requestFactory->createRequest($method, uri: $uri);
        $req = Util::withSetHeaders($req, headers: $headers);

        // @phpstan-ignore-next-line
        $rsp = $this->sendRequest($req, data: $body, opts: $opts, redirectCount: 0, retryCount: 0);

        $decoded = Util::decodeContent($rsp);

        if (!is_null($stream)) {
            return new $stream(
                convert: $convert,
                request: $req,
                response: $rsp,
                stream: $decoded
            );
        }

        if (!is_null($page)) {
            return new $page(
                convert: $convert,
                client: $this,
                request: $req,
                options: $opts,
                data: $decoded,
            );
        }

        if (!is_null($convert)) {
            return Conversion::coerce($convert, value: $decoded);
        }

        return $decoded;
    }

    /** @return array<string, string> */
    protected function authHeaders(): array
    {
        return [];
    }

    /**
     * @param string|list<string> $path
     * @param array<string, mixed> $query
     * @param array<string, string|int|list<string|int>|null> $headers
     * @param RequestOptions|array{
     *   timeout?: float|null,
     *   maxRetries?: int|null,
     *   initialRetryDelay?: float|null,
     *   maxRetryDelay?: float|null,
     *   extraHeaders?: list<string>|null,
     *   extraQueryParams?: list<string>|null,
     *   extraBodyParams?: list<string>|null,
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
        $opts = [...$this->options->__serialize(), ...RequestOptions::parse($opts)->__serialize()];
        $options = new RequestOptions(...$opts);

        $parsedPath = Util::parsePath($path);

        /** @var array<string, mixed> $mergedQuery */
        $mergedQuery = array_merge_recursive($query, $options->extraQueryParams);
        $uri = Util::joinUri($this->baseUrl, path: $parsedPath, query: $mergedQuery)->__toString();

        /** @var array<string, string|list<string>|null> $mergedHeaders */
        $mergedHeaders = [...$this->headers,
            ...$this->authHeaders(),
            ...$headers,
            ...$options->extraHeaders, ];

        $req = ['method' => strtoupper($method), 'path' => $uri, 'query' => $mergedQuery, 'headers' => $mergedHeaders, 'body' => $body];

        return [$req, $options];
    }

    protected function followRedirect(
        ResponseInterface $rsp,
        RequestInterface $req
    ): RequestInterface {
        $location = $rsp->getHeaderLine('Location');
        if (!$location) {
            throw new \RuntimeException('Redirection without Location header');
        }

        $uri = Util::joinUri($req->getUri(), path: $location);

        return $req->withUri($uri);
    }

    /**
     * @param bool|int|float|string|resource|\Traversable<mixed>|array<string,
     * mixed,>|null $data
     */
    protected function sendRequest(
        RequestInterface $req,
        mixed $data,
        RequestOptions $opts,
        int $retryCount,
        int $redirectCount,
    ): ResponseInterface {
        $req = Util::withSetBody($this->streamFactory, req: $req, body: $data);
        $rsp = $this->transporter->sendRequest($req);
        $code = $rsp->getStatusCode();

        if ($code >= 300 && $code < 400) {
            if ($redirectCount >= 20) {
                throw new \RuntimeException('Maximum redirects exceeded');
            }

            $req = $this->followRedirect($rsp, req: $req);

            return $this->sendRequest($req, data: $data, opts: $opts, retryCount: $retryCount, redirectCount: ++$redirectCount);
        }

        if ($code >= 400 && $code < 500) {
            throw APIStatusError::from(request: $req, response: $rsp);
        }

        if ($code >= 500 && $retryCount < $opts->maxRetries) {
            usleep((int) $opts->initialRetryDelay);

            return $this->sendRequest($req, data: $data, opts: $opts, retryCount: ++$retryCount, redirectCount: $redirectCount);
        }

        return $rsp;
    }
}
