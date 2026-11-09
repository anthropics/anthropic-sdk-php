<?php

declare(strict_types=1);

namespace Anthropic\Vertex;

use Anthropic\Client;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\RequestTransformer;
use Anthropic\Core\Util;
use Anthropic\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/** @internal */
final class VertexMiddleware implements Middleware
{
    /**
     * @param \Closure(): string $projectId
     * @param \Closure(RequestInterface): RequestInterface $authorize
     */
    public function __construct(
        private StreamFactoryInterface $streamFactory,
        private string $location,
        private \Closure $projectId,
        private \Closure $authorize,
    ) {}

    public function handle(RequestInterface $request, \Closure $callNext): ResponseInterface
    {
        return $callNext(($this->authorize)($this->rewriteRequest($request)));
    }

    private function rewriteRequest(RequestInterface $request): RequestInterface
    {
        $path = $request->getUri()->getPath();

        if (str_ends_with($path, '/v1/messages/count_tokens')) {
            $prefix = substr($path, 0, -strlen('/v1/messages/count_tokens'));

            return self::dropFirstPartyHeaders(new RequestTransformer($request, $this->streamFactory))
                ->setBodyParamDefault('anthropic_version', Client::ANTHROPIC_API_VERSION)
                ->setPath($prefix.$this->modelsPath().'/count-tokens:rawPredict')
                ->dropQueryParam('beta')
                ->build();
        }

        if (str_ends_with($path, '/v1/messages')) {
            $prefix = substr($path, 0, -strlen('/v1/messages'));
            $r = self::dropFirstPartyHeaders(new RequestTransformer($request, $this->streamFactory));
            $r->setBodyParamDefault('anthropic_version', Client::ANTHROPIC_API_VERSION);

            $model = $r->takeBodyParam('model');
            // Some servers drop ";" and what follows it from a segment before routing, so ";x" can be read as "" and "..;x" as "..".
            if (!is_string($model) || '' === $model || str_starts_with($model, ';')) {
                throw new \InvalidArgumentException('Request body must contain a non-empty string `model`.');
            }
            // Without a ";" the method name ends the segment, so "..:rawPredict" is not a dot segment.
            if (in_array(strstr($model, ';', true), ['.', '..'], true)) {
                throw new \InvalidArgumentException(sprintf('The path "%s" has the dot segment "%s", which would send the request to a different URL. A path parameter cannot be "." or "..".', "/publishers/anthropic/models/{$model}", $model));
            }
            // ";" stays escaped: the method name follows it in the same segment, so a server that drops ";x" would drop the method name too.
            $model = str_replace(['%40', '%3A'], ['@', ':'], rawurlencode($model));
            $method = (bool) $r->getBodyParam('stream') ? 'streamRawPredict' : 'rawPredict';

            return $r
                ->setPath("{$prefix}{$this->modelsPath()}/{$model}:{$method}")
                ->dropQueryParam('beta')
                ->build();
        }

        if (false !== ($i = strpos($path, '/v1/'))) {
            throw new AnthropicException(substr($path, $i).' is not available via Vertex — use new Anthropic\Client() for this resource.');
        }

        return $request;
    }

    private static function dropFirstPartyHeaders(RequestTransformer $r): RequestTransformer
    {
        return $r
            ->dropHeader('anthropic-version')
            ->dropHeader('anthropic-workspace-id');
    }

    private function modelsPath(): string
    {
        return Util::parsePath(['/projects/%1$s/locations/%2$s/publishers/anthropic/models', ($this->projectId)(), $this->location]);
    }
}
