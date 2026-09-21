<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents;

use Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock;
use Anthropic\Beta\Sessions\BetaManagedAgentsSystemMessageEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents\Data\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent\Result;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for events that can be sent to a session.
 *
 * @phpstan-import-type ManagedAgentsUserMessageEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent
 * @phpstan-import-type ManagedAgentsUserInterruptEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEvent
 * @phpstan-import-type ManagedAgentsUserToolConfirmationEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent
 * @phpstan-import-type ManagedAgentsUserCustomToolResultEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent
 * @phpstan-import-type ManagedAgentsUserDefineOutcomeEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent
 * @phpstan-import-type BetaManagedAgentsUserToolResultEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent
 * @phpstan-import-type BetaManagedAgentsSystemMessageEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemMessageEvent
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content as ContentShape1
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent\Content as ContentShape2
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric
 *
 * @phpstan-type DataVariants = ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsUserDefineOutcomeEvent|BetaManagedAgentsUserToolResultEvent|BetaManagedAgentsSystemMessageEvent
 * @phpstan-type DataShape = DataVariants|ManagedAgentsUserMessageEventShape|ManagedAgentsUserInterruptEventShape|ManagedAgentsUserToolConfirmationEventShape|ManagedAgentsUserCustomToolResultEventShape|ManagedAgentsUserDefineOutcomeEventShape|BetaManagedAgentsUserToolResultEventShape|BetaManagedAgentsSystemMessageEventShape
 */
final class Data implements ConverterSource
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
            'user.message' => ManagedAgentsUserMessageEvent::class,
            'user.interrupt' => ManagedAgentsUserInterruptEvent::class,
            'user.tool_confirmation' => ManagedAgentsUserToolConfirmationEvent::class,
            'user.custom_tool_result' => ManagedAgentsUserCustomToolResultEvent::class,
            'user.define_outcome' => ManagedAgentsUserDefineOutcomeEvent::class,
            'user.tool_result' => BetaManagedAgentsUserToolResultEvent::class,
            'system.message' => BetaManagedAgentsSystemMessageEvent::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::USER_MESSAGE|'user.message' ? list<ContentShape>|null : ($type is Type::USER_CUSTOM_TOOL_RESULT|'user.custom_tool_result' ? list<ContentShape1>|null : ($type is Type::USER_TOOL_RESULT|'user.tool_result' ? list<ContentShape2>|null : list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>|null))) $content
     * @param Result|value-of<Result>|null $result
     * @param RubricShape|null $rubric
     *
     * @return ($type is Type::USER_MESSAGE|'user.message' ? ManagedAgentsUserMessageEvent : ($type is Type::USER_INTERRUPT|'user.interrupt' ? ManagedAgentsUserInterruptEvent : ($type is Type::USER_TOOL_CONFIRMATION|'user.tool_confirmation' ? ManagedAgentsUserToolConfirmationEvent : ($type is Type::USER_CUSTOM_TOOL_RESULT|'user.custom_tool_result' ? ManagedAgentsUserCustomToolResultEvent : ($type is Type::USER_DEFINE_OUTCOME|'user.define_outcome' ? ManagedAgentsUserDefineOutcomeEvent : ($type is Type::USER_TOOL_RESULT|'user.tool_result' ? BetaManagedAgentsUserToolResultEvent : ($type is Type::SYSTEM_MESSAGE|'system.message' ? BetaManagedAgentsSystemMessageEvent : ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsUserDefineOutcomeEvent|BetaManagedAgentsUserToolResultEvent|BetaManagedAgentsSystemMessageEvent)))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $id,
        ?array $content = null,
        ?\DateTimeInterface $processedAt = null,
        ?string $sessionThreadID = null,
        Result|string|null $result = null,
        ?string $toolUseID = null,
        ?string $denyMessage = null,
        ?string $customToolUseID = null,
        ?bool $isError = null,
        ?string $description = null,
        ?int $maxIterations = null,
        ?string $outcomeID = null,
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric|null $rubric = null,
    ): ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsUserDefineOutcomeEvent|BetaManagedAgentsUserToolResultEvent|BetaManagedAgentsSystemMessageEvent {
        return match ($type) {
            Type::USER_MESSAGE, 'user.message' => ManagedAgentsUserMessageEvent::with(
                type: 'user.message',
                id: $id,
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                processedAt: $processedAt,
            ),
            Type::USER_INTERRUPT, 'user.interrupt' => ManagedAgentsUserInterruptEvent::with(
                type: 'user.interrupt',
                id: $id,
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::USER_TOOL_CONFIRMATION, 'user.tool_confirmation' => ManagedAgentsUserToolConfirmationEvent::with(
                type: 'user.tool_confirmation',
                id: $id,
                result: $result ?? throw new \ArgumentCountError('$result is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                denyMessage: $denyMessage,
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::USER_CUSTOM_TOOL_RESULT, 'user.custom_tool_result' => ManagedAgentsUserCustomToolResultEvent::with(
                type: 'user.custom_tool_result',
                id: $id,
                customToolUseID: $customToolUseID ?? throw new \ArgumentCountError('$customToolUseID is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::USER_DEFINE_OUTCOME, 'user.define_outcome' => ManagedAgentsUserDefineOutcomeEvent::with(
                type: 'user.define_outcome',
                id: $id,
                description: $description ?? throw new \ArgumentCountError('$description is required'),
                maxIterations: $maxIterations,
                outcomeID: $outcomeID ?? throw new \ArgumentCountError('$outcomeID is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                rubric: $rubric ?? throw new \ArgumentCountError('$rubric is required'),
            ),
            Type::USER_TOOL_RESULT, 'user.tool_result' => BetaManagedAgentsUserToolResultEvent::with(
                type: 'user.tool_result',
                id: $id,
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::SYSTEM_MESSAGE, 'system.message' => BetaManagedAgentsSystemMessageEvent::with(
                type: 'system.message',
                id: $id,
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                processedAt: $processedAt,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
