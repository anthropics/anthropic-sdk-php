<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/** @internal */
final class RequestTransformer
{
    /** @var array<mixed>|null lazily decoded on first body access */
    private ?array $body = null;

    private bool $bodyDirty = false;

    private string $path;

    /** @var array<int|string,mixed> */
    private array $query;

    /** @var array<string,string> */
    private array $setHeaders = [];

    /** @var list<string> */
    private array $dropHeaders = [];

    public function __construct(private RequestInterface $request, private StreamFactoryInterface $streamFactory)
    {
        $uri = $request->getUri();
        $this->path = $uri->getPath();
        parse_str($uri->getQuery(), $query);
        $this->query = $query;
    }

    public function takeBodyParam(string $key): mixed
    {
        $body = $this->decodedBody();
        if (!array_key_exists($key, $body)) {
            return null;
        }
        $v = $body[$key];
        unset($this->body[$key]);
        $this->bodyDirty = true;

        return $v;
    }

    public function getBodyParam(string $key): mixed
    {
        return $this->decodedBody()[$key] ?? null;
    }

    public function setBodyParam(string $key, mixed $v): static
    {
        $this->decodedBody();
        $this->body[$key] = $v;
        $this->bodyDirty = true;

        return $this;
    }

    public function setBodyParamDefault(string $key, mixed $v): static
    {
        if (null === ($this->decodedBody()[$key] ?? null)) {
            $this->body[$key] = $v;
            $this->bodyDirty = true;
        }

        return $this;
    }

    /** @return array<mixed> */
    public function getBody(): array
    {
        return $this->decodedBody();
    }

    /** @param array<mixed> $body */
    public function replaceBody(array $body): static
    {
        $this->body = $body;
        $this->bodyDirty = true;

        return $this;
    }

    /**
     * @return array<mixed>
     *
     * @phpstan-assert !null $this->body
     */
    private function decodedBody(): array
    {
        if (null === $this->body) {
            $stream = $this->request->getBody();
            $decoded = json_decode((string) $stream, true);
            if ($stream->isSeekable()) {
                $stream->rewind();
            }
            if (!is_array($decoded)) {
                throw new \InvalidArgumentException('Expected request body to be a JSON object.');
            }
            $this->body = $decoded;
        }

        return $this->body;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function dropQueryParam(string $key): static
    {
        unset($this->query[$key]);

        return $this;
    }

    public function getHeader(string $name): string
    {
        return $this->request->getHeaderLine($name);
    }

    public function setHeader(string $name, string $v): static
    {
        $this->setHeaders[$name] = $v;

        return $this;
    }

    public function dropHeader(string $name): static
    {
        $this->dropHeaders[] = $name;

        return $this;
    }

    public function build(): RequestInterface
    {
        $uri = $this->request->getUri()->withPath($this->path)->withQuery(http_build_query($this->query));
        $req = $this->request->withUri($uri, preserveHost: true);

        foreach ($this->setHeaders as $name => $v) {
            $req = $req->withHeader($name, $v);
        }
        foreach ($this->dropHeaders as $name) {
            $req = $req->withoutHeader($name);
        }

        if (!$this->bodyDirty) {
            return $req;
        }

        return $req
            ->withoutHeader('Content-Length')
            ->withBody($this->streamFactory->createStream(json_encode($this->body, flags: Util::JSON_ENCODE_FLAGS)));
    }
}
