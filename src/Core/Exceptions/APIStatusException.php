<?php

namespace Anthropic\Core\Exceptions;

use Anthropic\Core\Util;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class APIStatusException extends APIException
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

        $summary = Util::prettyEncodeJson(['status' => $this->status, 'body' => Util::decodeJson($response->getBody())]);

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

        return new $cls(request: $request, response: $response, message: $message);
    }
}
