<?php

namespace Anthropic\Core\Errors;

use Anthropic\Core\Util;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class APIStatusError extends APIError
{
    /** @var string */
    protected const DESC = 'Anthropic API Status Error';

    public ?int $status;

    public function __construct(
        public RequestInterface $request,
        ResponseInterface $response,
        ?\Throwable $previous = null,
        string $message = '',
    ) {
        $this->response = $response;
        $this->status = $response->getStatusCode();

        $summary = 'Status: '.$this->status.PHP_EOL
            .'Response Body: '.Util::prettyEncodeJson(Util::decodeJson($response->getBody())).PHP_EOL
            .'Request Body: '.Util::prettyEncodeJson(Util::decodeJson($request->getBody())).PHP_EOL;

        if ('' != $message) {
            $summary .= $message.PHP_EOL.$summary;
        }

        parent::__construct(request: $request, message: $summary, previous: $previous);
    }

    public static function from(
        RequestInterface $request,
        ResponseInterface $response,
        string $message = ''
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

        return new $cls(request: $request, response: $response, message: $message);
    }
}
