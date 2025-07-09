<?php

namespace Anthropic\Errors;

use Psr\Http\Message\RequestInterface;

class APITimeoutError extends APIConnectionError
{
    public function __construct(
        public RequestInterface $request,
        ?\Throwable $previous = null,
        string $message = 'Request timed out.',
    ) {
        parent::__construct(request: $request, message: $message, previous: $previous);
    }
}
