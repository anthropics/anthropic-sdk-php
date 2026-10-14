<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

trait ResponseProxy
{
    private ResponseInterface $response;

    public function getProtocolVersion(): string
    {
        return $this->response->getProtocolVersion();
    }

    public function withProtocolVersion(string $version): static
    {
        return $this->withResponse($this->response->withProtocolVersion($version));
    }

    public function getHeaders(): array
    {
        return $this->response->getHeaders();
    }

    public function hasHeader(string $name): bool
    {
        return $this->response->hasHeader($name);
    }

    public function getHeader(string $name): array
    {
        return $this->response->getHeader($name);
    }

    public function getHeaderLine(string $name): string
    {
        return $this->response->getHeaderLine($name);
    }

    public function withHeader(string $name, $value): static
    {
        return $this->withResponse($this->response->withHeader($name, value: $value));
    }

    public function withAddedHeader(string $name, $value): static
    {
        return $this->withResponse($this->response->withAddedHeader($name, value: $value));
    }

    public function withoutHeader(string $name): static
    {
        return $this->withResponse($this->response->withoutHeader($name));
    }

    public function getBody(): StreamInterface
    {
        return $this->response->getBody();
    }

    public function withBody(StreamInterface $body): static
    {
        return $this->withResponse($this->response->withBody($body));
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function withStatus(int $code, string $reasonPhrase = ''): static
    {
        return $this->withResponse($this->response->withstatus($code, reasonPhrase: $reasonPhrase));
    }

    public function getReasonPhrase(): string
    {
        return $this->response->getReasonPhrase();
    }

    /**
     * A copy of this response that reads from `$response` instead.
     */
    private function withResponse(ResponseInterface $response): static
    {
        $self = clone $this;
        $self->response = $response;

        return $self;
    }
}
