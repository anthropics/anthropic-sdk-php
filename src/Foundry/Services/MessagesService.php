<?php

declare(strict_types=1);

namespace Anthropic\Foundry\Services;

use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Foundry\Client;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Messages\MessageParam;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\Messages\OutputConfig;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawContentBlockStopEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;
use Anthropic\Messages\ThinkingConfigAdaptive;
use Anthropic\Messages\ThinkingConfigDisabled;
use Anthropic\Messages\ThinkingConfigEnabled;
use Anthropic\Messages\ToolChoiceAny;
use Anthropic\Messages\ToolChoiceAuto;
use Anthropic\Messages\ToolChoiceNone;
use Anthropic\Messages\ToolChoiceTool;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\MessagesContract;

/**
 * @phpstan-import-type MessageParamShape from \Anthropic\Messages\MessageParam
 * @phpstan-import-type MetadataShape from \Anthropic\Messages\Metadata
 * @phpstan-import-type OutputConfigShape from \Anthropic\Messages\OutputConfig
 * @phpstan-import-type SystemShape from \Anthropic\Messages\MessageCreateParams\System
 * @phpstan-import-type ThinkingConfigParamShape from \Anthropic\Messages\ThinkingConfigParam
 * @phpstan-import-type ToolChoiceShape from \Anthropic\Messages\ToolChoice
 * @phpstan-import-type ToolUnionShape from \Anthropic\Messages\ToolUnion
 * @phpstan-import-type MessageCountTokensToolShape from \Anthropic\Messages\MessageCountTokensTool
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MessagesService implements MessagesContract
{
    /**
     * @api
     */
    public MessagesRawService $raw;

    /**
     * @internal
     */
    public function __construct(Client $client)
    {
        $this->raw = new MessagesRawService($client);
    }

    /**
     * @api
     *
     * @param list<MessageParam|MessageParamShape> $messages
     * @param Model::CLAUDE_OPUS_4_5|Model::CLAUDE_OPUS_4_6|Model::CLAUDE_SONNET_4_5|Model::CLAUDE_HAIKU_4_5 $model
     * @param Metadata|MetadataShape $metadata
     * @param OutputConfig|OutputConfigShape $outputConfig
     * @param list<string> $stopSequences
     * @param SystemShape $system
     * @param ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive|ThinkingConfigParamShape|null $thinking
     * @param ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|ToolChoiceShape|null $toolChoice
     * @param list<ToolUnionShape> $tools
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        int $maxTokens,
        array $messages,
        Model|string $model,
        ?string $inferenceGeo = null,
        Metadata|array|null $metadata = null,
        OutputConfig|array|null $outputConfig = null,
        ServiceTier|string|null $serviceTier = null,
        ?array $stopSequences = null,
        string|array|null $system = null,
        ?float $temperature = null,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking = null,
        ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        RequestOptions|array|null $requestOptions = null,
    ): Message {
        $params = Util::removeNulls(
            [
                'maxTokens' => $maxTokens,
                'messages' => $messages,
                'model' => $model,
                'metadata' => $metadata,
                'outputConfig' => $outputConfig,
                'serviceTier' => $serviceTier,
                'stopSequences' => $stopSequences,
                'system' => $system,
                'temperature' => $temperature,
                'thinking' => $thinking,
                'toolChoice' => $toolChoice,
                'tools' => $tools,
                'topK' => $topK,
                'topP' => $topP,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * @param list<MessageParam|MessageParamShape> $messages
     * @param Model::CLAUDE_OPUS_4_5|Model::CLAUDE_OPUS_4_6|Model::CLAUDE_SONNET_4_5|Model::CLAUDE_HAIKU_4_5 $model
     * @param Metadata|MetadataShape $metadata
     * @param OutputConfig|OutputConfigShape $outputConfig
     * @param list<string> $stopSequences
     * @param SystemShape $system
     * @param ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive|ThinkingConfigParamShape|null $thinking
     * @param ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|ToolChoiceShape|null $toolChoice
     * @param list<ToolUnionShape> $tools
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseStream<RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent,>
     *
     * @throws APIException
     */
    public function createStream(
        int $maxTokens,
        array $messages,
        Model|string $model,
        ?string $inferenceGeo = null,
        Metadata|array|null $metadata = null,
        OutputConfig|array|null $outputConfig = null,
        ServiceTier|string|null $serviceTier = null,
        ?array $stopSequences = null,
        string|array|null $system = null,
        ?float $temperature = null,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking = null,
        ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        RequestOptions|array|null $requestOptions = null,
    ): BaseStream {
        $params = Util::removeNulls(
            [
                'maxTokens' => $maxTokens,
                'messages' => $messages,
                'model' => $model,
                'metadata' => $metadata,
                'outputConfig' => $outputConfig,
                'serviceTier' => $serviceTier,
                'stopSequences' => $stopSequences,
                'system' => $system,
                'temperature' => $temperature,
                'thinking' => $thinking,
                'toolChoice' => $toolChoice,
                'tools' => $tools,
                'topK' => $topK,
                'topP' => $topP,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createStream(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * @param list<MessageParam|MessageParamShape> $messages
     * @param Model::CLAUDE_OPUS_4_5|Model::CLAUDE_OPUS_4_6|Model::CLAUDE_SONNET_4_5|Model::CLAUDE_HAIKU_4_5 $model
     * @param OutputConfig|OutputConfigShape $outputConfig
     * @param SystemShape $system
     * @param ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive|ThinkingConfigParamShape|null $thinking
     * @param ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|ToolChoiceShape|null $toolChoice
     * @param list<MessageCountTokensToolShape> $tools
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function countTokens(
        array $messages,
        Model|string $model,
        OutputConfig|array|null $outputConfig = null,
        string|array|null $system = null,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking = null,
        ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageTokensCount {
        $params = Util::removeNulls(
            [
                'messages' => $messages,
                'model' => $model,
                'outputConfig' => $outputConfig,
                'system' => $system,
                'thinking' => $thinking,
                'toolChoice' => $toolChoice,
                'tools' => $tools,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->countTokens(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
