<?php

declare(strict_types=1);

namespace Anthropic\Vertex;

use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\RequestTransformer;
use Anthropic\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/** @internal */
final class VertexMiddleware implements Middleware
{
    private const VERSION = 'vertex-2023-10-16';

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
                ->setBodyParamDefault('anthropic_version', self::VERSION)
                ->setPath($prefix.$this->modelsPath().'/count-tokens:rawPredict')
                ->dropQueryParam('beta')
                ->build();
        }

        if (str_ends_with($path, '/v1/messages')) {
            $prefix = substr($path, 0, -strlen('/v1/messages'));
            $r = self::dropFirstPartyHeaders(new RequestTransformer($request, $this->streamFactory));
            $r->setBodyParamDefault('anthropic_version', self::VERSION);

            $model = $r->takeBodyParam('model');
            if (!is_string($model) || '' === $model) {
                throw new \InvalidArgumentException('Request body must contain a non-empty string `model`.');
            }
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
            ->dropHeader('anthropic-user-profile-id')
            ->dropHeader('anthropic-workspace-id');
    }

    private function modelsPath(): string
    {
        return sprintf('/projects/%s/locations/%s/publishers/anthropic/models', ($this->projectId)(), $this->location);
    }
}
