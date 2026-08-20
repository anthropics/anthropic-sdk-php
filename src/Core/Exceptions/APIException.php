<?php

namespace Anthropic\Core\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class APIException extends AnthropicException
{
    public ?int $status = null;

    public mixed $body = null;

    public ?ResponseInterface $response = null;

    public function __construct(
        public RequestInterface $request,
        ?\Throwable $previous = null,
        string $message = '',
    ) {
        parent::__construct(message: $message, previous: $previous);
    }

    public function getRequestID(): ?string
    {
        return $this->response?->getHeaderLine('request-id') ?: null;
    }

    public function getWorkspaceID(): ?string
    {
        return $this->response?->getHeaderLine('anthropic-workspace-id') ?: null;
    }
}
