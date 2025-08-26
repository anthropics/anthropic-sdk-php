<?php

namespace Anthropic\Core\Errors;

use Psr\Http\Message\RequestInterface;

class APITimeoutError extends APIConnectionError
{
    /** @var string */
    protected const DESC = 'Anthropic API Timeout Error';

    public function __construct(
        public RequestInterface $request,
        ?\Throwable $previous = null,
        string $message = 'Request timed out.',
    ) {
        parent::__construct(request: $request, message: $message, previous: $previous);
    }
}
