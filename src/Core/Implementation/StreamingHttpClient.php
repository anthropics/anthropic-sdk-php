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
            // Same options as Guzzle's PSR-18 sendRequest(): error statuses and redirects must
            // come back as responses so the base client can decide whether to retry or follow.
            return $this->inner->send($request, [
                'stream' => true,
                'http_errors' => false,
                'allow_redirects' => false,
            ]);
        }

        return $this->inner->sendRequest($request);
    }
}
