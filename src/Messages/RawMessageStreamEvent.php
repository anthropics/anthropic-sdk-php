<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\RawMessageDeltaEvent\Delta;
use Anthropic\Messages\RawMessageStreamEvent\Type;

/**
 * @phpstan-import-type RawMessageStartEventShape from \Anthropic\Messages\RawMessageStartEvent
 * @phpstan-import-type RawMessageDeltaEventShape from \Anthropic\Messages\RawMessageDeltaEvent
 * @phpstan-import-type RawMessageStopEventShape from \Anthropic\Messages\RawMessageStopEvent
 * @phpstan-import-type RawContentBlockStartEventShape from \Anthropic\Messages\RawContentBlockStartEvent
 * @phpstan-import-type RawContentBlockDeltaEventShape from \Anthropic\Messages\RawContentBlockDeltaEvent
 * @phpstan-import-type RawContentBlockStopEventShape from \Anthropic\Messages\RawContentBlockStopEvent
 * @phpstan-import-type MessageShape from \Anthropic\Messages\Message
 * @phpstan-import-type DeltaShape from \Anthropic\Messages\RawMessageDeltaEvent\Delta
 * @phpstan-import-type RawContentBlockDeltaShape from \Anthropic\Messages\RawContentBlockDelta
 * @phpstan-import-type MessageDeltaUsageShape from \Anthropic\Messages\MessageDeltaUsage
 * @phpstan-import-type ContentBlockShape from \Anthropic\Messages\RawContentBlockStartEvent\ContentBlock
 *
 * @phpstan-type RawMessageStreamEventVariants = RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent
 * @phpstan-type RawMessageStreamEventShape = RawMessageStreamEventVariants|RawMessageStartEventShape|RawMessageDeltaEventShape|RawMessageStopEventShape|RawContentBlockStartEventShape|RawContentBlockDeltaEventShape|RawContentBlockStopEventShape
 */
final class RawMessageStreamEvent implements ConverterSource
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
            'message_start' => RawMessageStartEvent::class,
            'message_delta' => RawMessageDeltaEvent::class,
            'message_stop' => RawMessageStopEvent::class,
            'content_block_start' => RawContentBlockStartEvent::class,
            'content_block_delta' => RawContentBlockDeltaEvent::class,
            'content_block_stop' => RawContentBlockStopEvent::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param Message|MessageShape|null $message
     * @param ($type is Type::MESSAGE_DELTA|'message_delta' ? Delta|DeltaShape|null : RawContentBlockDeltaShape|null) $delta
     * @param MessageDeltaUsage|MessageDeltaUsageShape|null $usage
     * @param ContentBlockShape|null $contentBlock
     *
     * @return ($type is Type::MESSAGE_START|'message_start' ? RawMessageStartEvent : ($type is Type::MESSAGE_DELTA|'message_delta' ? RawMessageDeltaEvent : ($type is Type::MESSAGE_STOP|'message_stop' ? RawMessageStopEvent : ($type is Type::CONTENT_BLOCK_START|'content_block_start' ? RawContentBlockStartEvent : ($type is Type::CONTENT_BLOCK_DELTA|'content_block_delta' ? RawContentBlockDeltaEvent : ($type is Type::CONTENT_BLOCK_STOP|'content_block_stop' ? RawContentBlockStopEvent : RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        Message|array|null $message = null,
        Delta|array|TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta|null $delta = null,
        MessageDeltaUsage|array|null $usage = null,
        TextBlock|array|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock|WebFetchToolResultBlock|CodeExecutionToolResultBlock|BashCodeExecutionToolResultBlock|TextEditorCodeExecutionToolResultBlock|ToolSearchToolResultBlock|ContainerUploadBlock|null $contentBlock = null,
        ?int $index = null,
    ): RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent {
        return match ($type) {
            Type::MESSAGE_START, 'message_start' => RawMessageStartEvent::with(
                message: $message ?? throw new \ArgumentCountError('$message is required'),
            ),
            Type::MESSAGE_DELTA, 'message_delta' => RawMessageDeltaEvent::with(
                delta: $delta ?? throw new \ArgumentCountError('$delta is required'),
                usage: $usage ?? throw new \ArgumentCountError('$usage is required'),
            ),
            Type::MESSAGE_STOP, 'message_stop' => RawMessageStopEvent::with(),
            Type::CONTENT_BLOCK_START, 'content_block_start' => RawContentBlockStartEvent::with(
                contentBlock: $contentBlock ?? throw new \ArgumentCountError('$contentBlock is required'),
                index: $index ?? throw new \ArgumentCountError('$index is required'),
            ),
            Type::CONTENT_BLOCK_DELTA, 'content_block_delta' => RawContentBlockDeltaEvent::with(
                // @phpstan-ignore argument.type
                delta: $delta ?? throw new \ArgumentCountError('$delta is required'),
                index: $index ?? throw new \ArgumentCountError('$index is required'),
            ),
            Type::CONTENT_BLOCK_STOP, 'content_block_stop' => RawContentBlockStopEvent::with(
                index: $index ?? throw new \ArgumentCountError('$index is required')
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
