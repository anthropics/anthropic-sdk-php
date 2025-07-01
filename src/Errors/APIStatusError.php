<?php

namespace Anthropic\Errors;

use Anthropic\Core\Util;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class APIStatusError extends APIError
{
    public ?int $status;

    public function __construct(
        public mixed $body,
        public RequestInterface $request,
        ResponseInterface $response,
        ?\Throwable $previous = null,
        string $message = ''
    ) {
        $this->response = $response;
        $this->status = $response->getStatusCode();
        $message |= json_encode(
            ['status' => $this->status, 'body' => $body],
            flags: Util::JSON_ENCODE_FLAGS,
        );
        parent::__construct(request: $request, message: $message, previous: $previous);
    }

    public static function from(
        mixed $body,
        RequestInterface $request,
        ResponseInterface $response
    ): self {
        $status = $response->getStatusCode();

        $cls = match (true) {
            400 === $status => BadRequestError::class,
            401 === $status => AuthenticationError::class,
            403 === $status => PermissionDeniedError::class,
            404 === $status => NotFoundError::class,
            409 === $status => ConflictError::class,
            422 === $status => UnprocessableEntityError::class,
            429 === $status => RateLimitError::class,
            $status >= 500 => InternalServerError::class,
            default => APIStatusError::class
        };

        return new $cls(body: $body, request: $request, response: $response);
    }
}
