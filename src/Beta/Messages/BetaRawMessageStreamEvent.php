<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent\Delta;
use Anthropic\Beta\Messages\BetaRawMessageStreamEvent\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaRawMessageStartEventShape from \Anthropic\Beta\Messages\BetaRawMessageStartEvent
 * @phpstan-import-type BetaRawMessageDeltaEventShape from \Anthropic\Beta\Messages\BetaRawMessageDeltaEvent
 * @phpstan-import-type BetaRawMessageStopEventShape from \Anthropic\Beta\Messages\BetaRawMessageStopEvent
 * @phpstan-import-type BetaRawContentBlockStartEventShape from \Anthropic\Beta\Messages\BetaRawContentBlockStartEvent
 * @phpstan-import-type BetaRawContentBlockDeltaEventShape from \Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent
 * @phpstan-import-type BetaRawContentBlockStopEventShape from \Anthropic\Beta\Messages\BetaRawContentBlockStopEvent
 * @phpstan-import-type BetaMessageShape from \Anthropic\Beta\Messages\BetaMessage
 * @phpstan-import-type BetaContextManagementResponseShape from \Anthropic\Beta\Messages\BetaContextManagementResponse
 * @phpstan-import-type DeltaShape from \Anthropic\Beta\Messages\BetaRawMessageDeltaEvent\Delta
 * @phpstan-import-type BetaRawContentBlockDeltaShape from \Anthropic\Beta\Messages\BetaRawContentBlockDelta
 * @phpstan-import-type BetaMessageDeltaUsageShape from \Anthropic\Beta\Messages\BetaMessageDeltaUsage
 * @phpstan-import-type BetaInputTransformationShape from \Anthropic\Beta\Messages\BetaInputTransformation
 * @phpstan-import-type ContentBlockShape from \Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock
 *
 * @phpstan-type BetaRawMessageStreamEventVariants = BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent
 * @phpstan-type BetaRawMessageStreamEventShape = BetaRawMessageStreamEventVariants|BetaRawMessageStartEventShape|BetaRawMessageDeltaEventShape|BetaRawMessageStopEventShape|BetaRawContentBlockStartEventShape|BetaRawContentBlockDeltaEventShape|BetaRawContentBlockStopEventShape
 */
final class BetaRawMessageStreamEvent implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'message_start' => BetaRawMessageStartEvent::class,
            'message_delta' => BetaRawMessageDeltaEvent::class,
            'message_stop' => BetaRawMessageStopEvent::class,
            'content_block_start' => BetaRawContentBlockStartEvent::class,
            'content_block_delta' => BetaRawContentBlockDeltaEvent::class,
            'content_block_stop' => BetaRawContentBlockStopEvent::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaMessage|BetaMessageShape|null $message
     * @param BetaContextManagementResponse|BetaContextManagementResponseShape|null $contextManagement
     * @param ($type is Type::MESSAGE_DELTA|'message_delta' ? Delta|DeltaShape|null : BetaRawContentBlockDeltaShape|null) $delta
     * @param BetaMessageDeltaUsage|BetaMessageDeltaUsageShape|null $usage
     * @param list<BetaInputTransformationShape>|null $inputTransformations
     * @param ContentBlockShape|null $contentBlock
     *
     * @return ($type is Type::MESSAGE_START|'message_start' ? BetaRawMessageStartEvent : ($type is Type::MESSAGE_DELTA|'message_delta' ? BetaRawMessageDeltaEvent : ($type is Type::MESSAGE_STOP|'message_stop' ? BetaRawMessageStopEvent : ($type is Type::CONTENT_BLOCK_START|'content_block_start' ? BetaRawContentBlockStartEvent : ($type is Type::CONTENT_BLOCK_DELTA|'content_block_delta' ? BetaRawContentBlockDeltaEvent : ($type is Type::CONTENT_BLOCK_STOP|'content_block_stop' ? BetaRawContentBlockStopEvent : BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaMessage|array|null $message = null,
        BetaContextManagementResponse|array|null $contextManagement = null,
        Delta|array|BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta|BetaCompactionContentBlockDelta|null $delta = null,
        BetaMessageDeltaUsage|array|null $usage = null,
        ?array $inputTransformations = null,
        BetaTextBlock|array|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaAdvisorToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock|BetaFallbackBlock|BetaMCPToolListingBlock|null $contentBlock = null,
        ?int $index = null,
    ): BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent {
        return match ($type) {
            Type::MESSAGE_START, 'message_start' => BetaRawMessageStartEvent::with(
                message: $message ?? throw new \ArgumentCountError('$message is required'),
            ),
            Type::MESSAGE_DELTA, 'message_delta' => BetaRawMessageDeltaEvent::with(
                contextManagement: $contextManagement,
                delta: $delta ?? throw new \ArgumentCountError('$delta is required'),
                usage: $usage ?? throw new \ArgumentCountError('$usage is required'),
                inputTransformations: $inputTransformations,
            ),
            Type::MESSAGE_STOP, 'message_stop' => BetaRawMessageStopEvent::with(),
            Type::CONTENT_BLOCK_START, 'content_block_start' => BetaRawContentBlockStartEvent::with(
                contentBlock: $contentBlock ?? throw new \ArgumentCountError('$contentBlock is required'),
                index: $index ?? throw new \ArgumentCountError('$index is required'),
            ),
            Type::CONTENT_BLOCK_DELTA, 'content_block_delta' => BetaRawContentBlockDeltaEvent::with(
                // @phpstan-ignore argument.type
                delta: $delta ?? throw new \ArgumentCountError('$delta is required'),
                index: $index ?? throw new \ArgumentCountError('$index is required'),
            ),
            Type::CONTENT_BLOCK_STOP, 'content_block_stop' => BetaRawContentBlockStopEvent::with(
                index: $index ?? throw new \ArgumentCountError('$index is required')
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
