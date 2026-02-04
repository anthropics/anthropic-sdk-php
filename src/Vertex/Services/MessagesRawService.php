<?php

declare(strict_types=1);

namespace Anthropic\Vertex\Services;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\RawMessageStreamEvent;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\MessagesRawContract;
use Anthropic\SSEStream;
use Anthropic\Vertex\Client;

/**
 * @see https://docs.cloud.google.com/vertex-ai/generative-ai/docs/partner-models/claude/use-claude
 * @see https://docs.cloud.google.com/vertex-ai/generative-ai/docs/partner-models/claude/count-tokens
 *
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
class MessagesRawService implements MessagesRawContract
{
    /**
     * Vertex AI specific Anthropic API version.
     * This version ensures compatibility with Vertex AI's Claude model integration
     * and follows the versioning scheme required by Google's Vertex AI platform.
     */
    private const ANTHROPIC_VERSION = 'vertex-2023-10-16';

    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    public function create(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$endpoint, $parsed, $options] = $this->prepareCreateRequest($params, $requestOptions, false);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: $endpoint,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
            body: $parsed,
            options: $options,
            convert: Message::class,
        );
    }

    public function createStream(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$endpoint, $parsed, $options] = $this->prepareCreateRequest($params, $requestOptions, true);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: $endpoint,
            headers: [
                'Accept' => 'text/event-stream',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
            body: $parsed,
            options: $options,
            convert: RawMessageStreamEvent::class,
            stream: SSEStream::class,
        );
    }

    public function countTokens(
        array|MessageCountTokensParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCountTokensParams::parseRequest($params, $requestOptions);

        $endpoint = $this->client->getApiEndpoint().'/count-tokens:rawPredict';

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: $endpoint,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
            body: $parsed,
            options: $options,
            convert: MessageTokensCount::class,
        );
    }

    /**
     * @param array<string,mixed>|MessageCreateParams $params
     * @param RequestOptions|RequestOpts|null $requestOptions
     *
     * @return array{0: string, 1: array<string, mixed>, 2: RequestOptions}
     */
    private function prepareCreateRequest(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions,
        bool $stream,
    ): array {
        [$parsed, $options] = MessageCreateParams::parseRequest($params, $requestOptions);

        $modelId = $parsed['model'];

        if (!is_string($modelId) || '' === $modelId) {
            throw new \InvalidArgumentException('Model id must be a non-empty-string representing the Vertex AI model to use.');
        }

        unset($parsed['model']);

        $parsed['anthropic_version'] = self::ANTHROPIC_VERSION;
        $parsed['stream'] = $stream;

        $specifier = $stream ? 'streamRawPredict' : 'rawPredict';

        $endpoint = sprintf('%s/%s:%s', $this->client->getApiEndpoint(), $modelId, $specifier);

        return [$endpoint, $parsed, $options];
    }
}
