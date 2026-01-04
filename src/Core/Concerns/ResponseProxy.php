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
        $self = clone $this;
        $self->response = $this->response->withProtocolVersion($version);

        return $self;
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
        $self = clone $this;
        $self->response = $this->response->withHeader($name, value: $value);

        return $self;
    }

    public function withAddedHeader(string $name, $value): static
    {
        $self = clone $this;
        $self->response = $this->response->withAddedHeader($name, value: $value);

        return $self;
    }

    public function withoutHeader(string $name): static
    {
        $self = clone $this;
        $self->response = $this->response->withoutHeader($name);

        return $self;
    }

    public function getBody(): StreamInterface
    {
        return $this->response->getBody();
    }

    public function withBody(StreamInterface $body): static
    {
        $self = clone $this;
        $self->response = $this->response->withBody($body);

        return $self;
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function withStatus(int $code, string $reasonPhrase = ''): static
    {
        $self = clone $this;
        $self->response = $this->response->withstatus($code, reasonPhrase: $reasonPhrase);

        return $self;
    }

    public function getReasonPhrase(): string
    {
        return $this->response->getReasonPhrase();
    }
}
