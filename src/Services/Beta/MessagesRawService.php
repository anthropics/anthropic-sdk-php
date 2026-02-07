<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaContextManagementConfig;
use Anthropic\Beta\Messages\BetaJSONOutputFormat;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaMetadata;
use Anthropic\Beta\Messages\BetaOutputConfig;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageStreamEvent;
use Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition;
use Anthropic\Beta\Messages\MessageCountTokensParams;
use Anthropic\Beta\Messages\MessageCreateParams;
use Anthropic\Beta\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Beta\Messages\MessageCreateParams\Speed;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Messages\Model;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MessagesRawContract;
use Anthropic\SSEStream;

/**
 * @phpstan-import-type SystemShape from \Anthropic\Beta\Messages\MessageCountTokensParams\System
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\MessageCountTokensParams\Tool
 * @phpstan-import-type BetaMessageParamShape from \Anthropic\Beta\Messages\BetaMessageParam
 * @phpstan-import-type ContainerShape from \Anthropic\Beta\Messages\MessageCreateParams\Container
 * @phpstan-import-type BetaContextManagementConfigShape from \Anthropic\Beta\Messages\BetaContextManagementConfig
 * @phpstan-import-type BetaRequestMCPServerURLDefinitionShape from \Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition
 * @phpstan-import-type BetaMetadataShape from \Anthropic\Beta\Messages\BetaMetadata
 * @phpstan-import-type BetaOutputConfigShape from \Anthropic\Beta\Messages\BetaOutputConfig
 * @phpstan-import-type BetaJSONOutputFormatShape from \Anthropic\Beta\Messages\BetaJSONOutputFormat
 * @phpstan-import-type SystemShape from \Anthropic\Beta\Messages\MessageCreateParams\System as SystemShape1
 * @phpstan-import-type BetaThinkingConfigParamShape from \Anthropic\Beta\Messages\BetaThinkingConfigParam
 * @phpstan-import-type BetaToolChoiceShape from \Anthropic\Beta\Messages\BetaToolChoice
 * @phpstan-import-type BetaToolUnionShape from \Anthropic\Beta\Messages\BetaToolUnion
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MessagesRawService implements MessagesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Send a structured list of input messages with text and/or image content, and the model will generate the next message in the conversation.
     *
     * The Messages API can be used for either single queries or stateless multi-turn conversations.
     *
     * Learn more about the Messages API in our [user guide](https://docs.claude.com/en/docs/initial-setup)
     *
     * @param array{
     *   maxTokens: int,
     *   messages: list<BetaMessageParam|BetaMessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   container?: ContainerShape|null,
     *   contextManagement?: BetaContextManagementConfig|BetaContextManagementConfigShape|null,
     *   inferenceGeo?: string|null,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape>,
     *   metadata?: BetaMetadata|BetaMetadataShape,
     *   outputConfig?: BetaOutputConfig|BetaOutputConfigShape,
     *   outputFormat?: BetaJSONOutputFormat|BetaJSONOutputFormatShape|null,
     *   serviceTier?: ServiceTier|value-of<ServiceTier>,
     *   speed?: Speed|value-of<Speed>|null,
     *   stopSequences?: list<string>,
     *   system?: SystemShape1,
     *   temperature?: float,
     *   thinking?: BetaThinkingConfigParamShape,
     *   toolChoice?: BetaToolChoiceShape,
     *   tools?: list<BetaToolUnionShape>,
     *   topK?: int,
     *   topP?: float,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaMessage>
     *
     * @throws APIException
     */
    public function create(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: BetaMessage::class,
        );
    }

    /**
     * @api
     *
     * @param array{
     *   maxTokens: int,
     *   messages: list<BetaMessageParam|BetaMessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   container?: ContainerShape|null,
     *   contextManagement?: BetaContextManagementConfig|BetaContextManagementConfigShape|null,
     *   inferenceGeo?: string|null,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape>,
     *   metadata?: BetaMetadata|BetaMetadataShape,
     *   outputConfig?: BetaOutputConfig|BetaOutputConfigShape,
     *   outputFormat?: BetaJSONOutputFormat|BetaJSONOutputFormatShape|null,
     *   serviceTier?: ServiceTier|value-of<ServiceTier>,
     *   speed?: Speed|value-of<Speed>|null,
     *   stopSequences?: list<string>,
     *   system?: SystemShape1,
     *   temperature?: float,
     *   thinking?: BetaThinkingConfigParamShape,
     *   toolChoice?: BetaToolChoiceShape,
     *   tools?: list<BetaToolUnionShape>,
     *   topK?: int,
     *   topP?: float,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent,>,>
     *
     * @throws APIException
     */
    public function createStream(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $parsed['stream'] = true;
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages?beta=true',
            headers: Util::array_transform_keys(
                [
                    'Accept' => 'text/event-stream',
                    ...array_intersect_key(
                        $parsed,
                        array_flip(array_keys($header_params))
                    ),
                ],
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: BetaRawMessageStreamEvent::class,
            stream: SSEStream::class,
        );
    }

    /**
     * @api
     *
     * Count the number of tokens in a Message.
     *
     * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
     *
     * Learn more about token counting in our [user guide](https://docs.claude.com/en/docs/build-with-claude/token-counting)
     *
     * @param array{
     *   messages: list<BetaMessageParam|BetaMessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   contextManagement?: BetaContextManagementConfig|BetaContextManagementConfigShape|null,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape>,
     *   outputConfig?: BetaOutputConfig|BetaOutputConfigShape,
     *   outputFormat?: BetaJSONOutputFormat|BetaJSONOutputFormatShape|null,
     *   speed?: MessageCountTokensParams\Speed|value-of<MessageCountTokensParams\Speed>|null,
     *   system?: SystemShape,
     *   thinking?: BetaThinkingConfigParamShape,
     *   toolChoice?: BetaToolChoiceShape,
     *   tools?: list<ToolShape>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MessageCountTokensParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaMessageTokensCount>
     *
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCountTokensParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: BetaMessageTokensCount::class,
        );
    }
}
