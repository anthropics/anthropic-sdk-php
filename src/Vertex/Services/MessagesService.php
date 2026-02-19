<?php

declare(strict_types=1);

namespace Anthropic\Vertex\Services;

use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Util;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\CacheControlEphemeral;
use Anthropic\Messages\Model;
use Anthropic\Messages\OutputConfig;
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
 * Messages service for Vertex AI Anthropic models.
 *
 * Implements high-level API that matches the standard Anthropic interface
 * while handling Vertex AI-specific request/response transformations.
 */
class MessagesService implements MessagesContract
{
    /**
     * @internal
     */
    public function __construct(private MessagesRawService $raw) {}

    // @phpstan-ignore-next-line
    public function create(
        int $maxTokens,
        array $messages,
        Model|string $model,
        CacheControlEphemeral|array|null $cacheControl = null,
        ?string $container = null,
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
                'cacheControl' => $cacheControl,
                'container' => $container,
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

    // @phpstan-ignore-next-line
    public function createStream(
        int $maxTokens,
        array $messages,
        Model|string $model,
        CacheControlEphemeral|array|null $cacheControl = null,
        ?string $container = null,
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
                'cacheControl' => $cacheControl,
                'container' => $container,
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

    // @phpstan-ignore-next-line
    public function countTokens(
        array $messages,
        Model|string $model,
        CacheControlEphemeral|array|null $cacheControl = null,
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
                'cacheControl' => $cacheControl,
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
