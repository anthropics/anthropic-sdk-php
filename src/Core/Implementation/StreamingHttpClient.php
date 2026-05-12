<?php

declare(strict_types=1);

namespace Anthropic\Core\Implementation;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * Wraps a PSR-18 client and produces a response with a non-buffered body when
 * the underlying client requires an opt-in for streaming
 */
final class StreamingHttpClient implements ClientInterface
{
    public function __construct(private ClientInterface $inner) {}

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if (is_a($this->inner, '\GuzzleHttp\Client')) {
            return $this->inner->send($request, ['stream' => true]);
        }

        return $this->inner->sendRequest($request);
    }
}
