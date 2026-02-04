<?php

declare(strict_types=1);

namespace Anthropic\Bedrock\Services;

use Anthropic\Bedrock\BedrockEventStream;
use Anthropic\Bedrock\Client;
use Anthropic\Bedrock\Conversion\MessageTokensCountConverter;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Util;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
use Anthropic\Messages\RawMessageStreamEvent;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\MessagesRawContract;

/**
 * @see https://docs.aws.amazon.com/bedrock/latest/userguide/model-parameters-anthropic-claude-messages.html
 */
final class MessagesRawService implements MessagesRawContract
{
    private const ANTHROPIC_VERSION = 'bedrock-2023-05-31';
    private const BEDROCK_COUNT_TOKENS_PLACEHOLDER = 1024;

    public function __construct(private Client $client) {}

    public function create(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCreateParams::parseRequest($params, $requestOptions);

        $modelId = $parsed['model'];

        if (!is_string($modelId) || '' === $modelId) {
            throw new \InvalidArgumentException('Model id must be a non-empty-string representing the Anthropic Bedrock model to use.');
        }

        unset($parsed['model']);

        $parsed['anthropic_version'] = self::ANTHROPIC_VERSION;

        // @see https://github.com/aws/aws-sdk-php/blob/master/src/data/bedrock/2023-04-20/api-2.json
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: '/model/'.rawurlencode($modelId).'/invoke',
            headers: [
                'Content-Type' => 'application/json',
                'X-Amzn-Bedrock-Accept' => 'application/json',
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
        [$parsed, $options] = MessageCreateParams::parseRequest($params, $requestOptions);

        $modelId = $parsed['model'];

        if (!is_string($modelId) || '' === $modelId) {
            throw new \InvalidArgumentException('Model id must be a non-empty-string representing the Anthropic Bedrock model to use.');
        }

        unset($parsed['model']);

        $parsed['anthropic_version'] = self::ANTHROPIC_VERSION;

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: '/model/'.rawurlencode($modelId).'/invoke-with-response-stream',
            headers: [
                'Content-Type' => 'application/json',
                'X-Amzn-Bedrock-Accept' => 'application/json',
            ],
            body: $parsed,
            options: $options,
            convert: RawMessageStreamEvent::class,
            stream: BedrockEventStream::class,
        );
    }

    public function countTokens(
        array|MessageCountTokensParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        // @see https://docs.aws.amazon.com/bedrock/latest/userguide/count-tokens.html
        [$parsed, $options] = MessageCountTokensParams::parseRequest($params, $requestOptions);

        $modelId = $parsed['model'];

        if (!is_string($modelId) || '' === $modelId) {
            throw new \InvalidArgumentException('Model id must be a non-empty-string representing the Anthropic Bedrock model to use.');
        }

        unset($parsed['model']);

        $parsed['anthropic_version'] = self::ANTHROPIC_VERSION;
        $parsed['max_tokens'] = self::BEDROCK_COUNT_TOKENS_PLACEHOLDER; // Required by Bedrock API but not used for token counting
        $payload = json_encode($parsed, flags: Util::JSON_ENCODE_FLAGS);

        $body = [
            'input' => [
                'invokeModel' => [
                    'body' => base64_encode($payload),
                ],
            ],
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: '/model/'.rawurlencode($modelId).'/count-tokens',
            headers: [
                'Content-Type' => 'application/json',
            ],
            body: $body,
            options: $options,
            convert: new MessageTokensCountConverter,
        );
    }
}
