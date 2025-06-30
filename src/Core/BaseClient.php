<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Anthropic\RequestOptions;
use Anthropic\Errors\APIStatusError;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BaseClient
{
    protected UriInterface $baseUrl;

    protected UriFactoryInterface $uriFactory;

    protected StreamFactoryInterface $streamFactory;

    protected RequestFactoryInterface $requestFactory;

    protected ClientInterface $requester;

    /**
     * @return array<string, string>
     */
    protected function authHeaders(): array
    {
        return [];
    }

    /**
     * @param string|list<string>                     $path
     * @param array<string, mixed>                    $query
     * @param array<string, string|list<string>|null> $headers
     * @param RequestOptions|array{
     *
     *     timeout?: float|null,
     *     maxRetries?: int|null,
     *     initialRetryDelay?: float|null,
     *     maxRetryDelay?: float|null,
     *     extraHeaders?: list<string>|null,
     *     extraQueryParams?: list<string>|null,
     *     extraBodyParams?: list<string>|null,
     *
     * }|null $opts
     *
     * @return array{RequestInterface, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        mixed $path,
        array $query,
        array $headers,
        mixed $opts,
    ): array {
        $opts = [...$this->options->__serialize(), ...RequestOptions::parse($opts)->__serialize()];
        $options = new RequestOptions(...$opts);

        $parsedPath = Util::parsePath($path);
        /** @var array<string, mixed> $mergedQuery */
        $mergedQuery = array_merge_recursive($query, $options->extraQueryParams);
        $uri = Util::joinUri($this->baseUrl, path: $parsedPath, query: $mergedQuery);
        /** @var array<string, string | list<string>> $mergedHeaders */
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
        RequestInterface $req,
    ): RequestInterface {
        $location = $rsp->getHeaderLine('Location');
        if (!$location) {
            throw new \RuntimeException('Redirection without Location header');
        }

        $uri = Util::joinUri($req->getUri(), path: $location);

        return $req->withUri($uri);
    }

    /**
     * @param array<
     * string, mixed
     * >|bool|int|float|string|resource|\Traversable<mixed>|null $data
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

        // if ($code >= 500 && $retryCount < $opts->max_retries) {
        //    usleep((int) ($opts->initial_retry_delay * 1_000_000));
        //    return $this->sendRequest($req, data: $data, opts: $opts, retryCount: ++$retryCount, redirectCount: $redirectCount);
        // }

        return $rsp;
    }

    /**
     * @param string|list<mixed>   $path
     * @param array<string, mixed> $query
     * @param array<string, mixed> $headers
     */
    public function request(
        string $method,
        mixed $path,
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

    /**
     * @param array<string, string|list<string>|null> $headers
     */
    public function __construct(
        protected array $headers,
        string $baseUrl,
        protected RequestOptions $options = new RequestOptions(),
    ) {

        $this->uriFactory = Psr17FactoryDiscovery::findUriFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();

        $this->baseUrl = $this->uriFactory->createUri($baseUrl);
        $this->requester = Psr18ClientDiscovery::find();

    }
}
