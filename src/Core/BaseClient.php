<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Anthropic\Errors\APIStatusError;
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

class BaseClient
{
    protected UriInterface $baseUrl;

    protected UriFactoryInterface $uriFactory;

    protected StreamFactoryInterface $streamFactory;

    protected RequestFactoryInterface $requestFactory;

    protected ClientInterface $requester;

    /**
     * @param array<string, null|int|list<int|string>|string> $headers
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
        $this->requester = Psr18ClientDiscovery::find();
    }

    /**
     * @param list<mixed>|string $path
     * @param array<string, mixed> $query
     * @param array<string, mixed> $headers
     */
    public function request(
        string $method,
        array|string $path,
        array $query = [],
        array $headers = [],
        mixed $body = null,
        mixed $options = [],
    ): mixed {
        // @phpstan-ignore-next-line
        [$req, $opts] = $this->buildRequest(method: $method, path: $path, query: $query, headers: $headers, opts: $options);

        // @phpstan-ignore-next-line
        $rsp = $this->sendRequest($req, data: $body, opts: $opts, redirectCount: 0, retryCount: 0);
        if (204 == $rsp->getStatusCode()) {
            return null; // Handle 204 No Content
        }

        return Util::decodeContent($rsp);
    }

    /**
     * @template Item
     * @template T of Pagination\AbstractPage<Item>
     *
     * @param T $page
     */
    public function requestApiList(object $page, RequestOptions $options): ResponseInterface
    {
        // @phpstan-ignore-next-line
        return null;
    }

    /** @return array<string, string> */
    protected function authHeaders(): array
    {
        return [];
    }

    /**
     * @param list<string>|string $path
     * @param array<string, mixed> $query
     * @param array<string, null|int|list<int|string>|string> $headers
     * @param null|array{
     *   timeout?: null|float,
     *   maxRetries?: null|int,
     *   initialRetryDelay?: null|float,
     *   maxRetryDelay?: null|float,
     *   extraHeaders?: null|list<string>,
     *   extraQueryParams?: null|list<string>,
     *   extraBodyParams?: null|list<string>,
     * }|RequestOptions $opts
     *
     * @return array{RequestInterface, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        array|string $path,
        array $query,
        array $headers,
        null|array|RequestOptions $opts,
    ): array {
        $opts = [...$this->options->__serialize(), ...RequestOptions::parse($opts)->__serialize()];
        $options = new RequestOptions(...$opts);

        $parsedPath = Util::parsePath($path);

        /** @var array<string, mixed> $mergedQuery */
        $mergedQuery = array_merge_recursive($query, $options->extraQueryParams);
        $uri = Util::joinUri($this->baseUrl, path: $parsedPath, query: $mergedQuery);

        /** @var array<string, list<string>|string> $mergedHeaders */
        $mergedHeaders = [...$this->headers,
            ...$this->authHeaders(),
            ...$headers,
            ...$options->extraHeaders, ];

        $req = $this->requestFactory->createRequest(strtoupper($method), uri: $uri);
        $req = Util::withSetHeaders($req, headers: $mergedHeaders);

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
     * @param null|array<string, mixed>|bool|float|int|resource|string|\Traversable<
     *   mixed
     * > $data
     */
    protected function sendRequest(
        RequestInterface $req,
        mixed $data,
        RequestOptions $opts,
        int $retryCount,
        int $redirectCount,
    ): ResponseInterface {
        $req = Util::withSetBody($this->streamFactory, req: $req, body: $data);
        $rsp = $this->requester->sendRequest($req);
        $code = $rsp->getStatusCode();

        if ($code >= 300 && $code < 400) {
            if ($redirectCount >= 20) {
                throw new \RuntimeException('Maximum redirects exceeded');
            }

            $req = $this->followRedirect($rsp, req: $req);

            return $this->sendRequest($req, data: $data, opts: $opts, retryCount: $retryCount, redirectCount: ++$redirectCount);
        }

        if ($code >= 400 && $code < 500) {
            throw APIStatusError::from(null, request: $req, response: $rsp);
        }

        if ($code >= 500 && $retryCount < $opts->maxRetries) {
            usleep((int) $opts->initialRetryDelay);

            return $this->sendRequest($req, data: $data, opts: $opts, retryCount: ++$retryCount, redirectCount: $redirectCount);
        }

        return $rsp;
    }
}
