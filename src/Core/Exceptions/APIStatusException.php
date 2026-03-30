<?php

namespace Anthropic\Core\Exceptions;

use Anthropic\Core\Util;
use Anthropic\ErrorType;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class APIStatusException extends APIException
{
    /** @var string */
    protected const DESC = 'Anthropic API Status Error';

    public ?int $status;

    public readonly ?ErrorType $type;

    public function __construct(
        public RequestInterface $request,
        ResponseInterface $response,
        ?\Throwable $previous = null,
        string $message = '',
        ?ErrorType $type = null,
    ) {
        $this->response = $response;
        $this->status = $response->getStatusCode();

        try {
            $body = Util::decodeJson($response->getBody());
        } catch (\JsonException) {
            $body = null;
        }

        $summary = Util::prettyEncodeJson(['status' => $this->status, 'body' => $body]);

        $errorType = Util::dig(Util::dig($body, 'error'), 'type');
        $this->type = $type ?? (is_string($errorType) ? ErrorType::tryFrom($errorType) : null);

        if ('' != $message) {
            $summary .= $message.PHP_EOL.$summary;
        }

        parent::__construct(request: $request, message: $summary, previous: $previous);
    }

    public static function from(
        RequestInterface $request,
        ResponseInterface $response,
        string $message = '',
        ?ErrorType $type = null,
    ): self {
        $status = $response->getStatusCode();

        $cls = match (true) {
            400 === $status => BadRequestException::class,
            401 === $status => AuthenticationException::class,
            403 === $status => PermissionDeniedException::class,
            404 === $status => NotFoundException::class,
            409 === $status => ConflictException::class,
            422 === $status => UnprocessableEntityException::class,
            429 === $status => RateLimitException::class,
            $status >= 500 => InternalServerException::class,
            default => APIStatusException::class
        };

        return new $cls(request: $request, response: $response, message: $message, type: $type);
    }
}
