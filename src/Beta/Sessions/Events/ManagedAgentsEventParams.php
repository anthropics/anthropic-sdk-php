<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsEventParams\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEventParams\Result;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for event parameters that can be sent to a session.
 *
 * @phpstan-import-type ManagedAgentsUserMessageEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams
 * @phpstan-import-type ManagedAgentsUserInterruptEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEventParams
 * @phpstan-import-type ManagedAgentsUserToolConfirmationEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEventParams
 * @phpstan-import-type ManagedAgentsUserCustomToolResultEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams
 * @phpstan-import-type ManagedAgentsUserDefineOutcomeEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams
 * @phpstan-import-type ManagedAgentsUserToolResultEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolResultEventParams
 * @phpstan-import-type ManagedAgentsSystemMessageEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSystemMessageEventParams
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams\Content as ContentShape1
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolResultEventParams\Content as ContentShape2
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams\Rubric
 *
 * @phpstan-type ManagedAgentsEventParamsVariants = ManagedAgentsUserMessageEventParams|ManagedAgentsUserInterruptEventParams|ManagedAgentsUserToolConfirmationEventParams|ManagedAgentsUserCustomToolResultEventParams|ManagedAgentsUserDefineOutcomeEventParams|ManagedAgentsUserToolResultEventParams|ManagedAgentsSystemMessageEventParams
 * @phpstan-type ManagedAgentsEventParamsShape = ManagedAgentsEventParamsVariants|ManagedAgentsUserMessageEventParamsShape|ManagedAgentsUserInterruptEventParamsShape|ManagedAgentsUserToolConfirmationEventParamsShape|ManagedAgentsUserCustomToolResultEventParamsShape|ManagedAgentsUserDefineOutcomeEventParamsShape|ManagedAgentsUserToolResultEventParamsShape|ManagedAgentsSystemMessageEventParamsShape
 */
final class ManagedAgentsEventParams implements ConverterSource
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
            'user.message' => ManagedAgentsUserMessageEventParams::class,
            'user.interrupt' => ManagedAgentsUserInterruptEventParams::class,
            'user.tool_confirmation' => ManagedAgentsUserToolConfirmationEventParams::class,
            'user.custom_tool_result' => ManagedAgentsUserCustomToolResultEventParams::class,
            'user.define_outcome' => ManagedAgentsUserDefineOutcomeEventParams::class,
            'user.tool_result' => ManagedAgentsUserToolResultEventParams::class,
            'system.message' => ManagedAgentsSystemMessageEventParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::USER_MESSAGE|'user.message' ? list<ContentShape>|null : ($type is Type::USER_CUSTOM_TOOL_RESULT|'user.custom_tool_result' ? list<ContentShape1>|null : ($type is Type::USER_TOOL_RESULT|'user.tool_result' ? list<ContentShape2>|null : list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>|null))) $content
     * @param Result|value-of<Result>|null $result
     * @param RubricShape|null $rubric
     *
     * @return ($type is Type::USER_MESSAGE|'user.message' ? ManagedAgentsUserMessageEventParams : ($type is Type::USER_INTERRUPT|'user.interrupt' ? ManagedAgentsUserInterruptEventParams : ($type is Type::USER_TOOL_CONFIRMATION|'user.tool_confirmation' ? ManagedAgentsUserToolConfirmationEventParams : ($type is Type::USER_CUSTOM_TOOL_RESULT|'user.custom_tool_result' ? ManagedAgentsUserCustomToolResultEventParams : ($type is Type::USER_DEFINE_OUTCOME|'user.define_outcome' ? ManagedAgentsUserDefineOutcomeEventParams : ($type is Type::USER_TOOL_RESULT|'user.tool_result' ? ManagedAgentsUserToolResultEventParams : ($type is Type::SYSTEM_MESSAGE|'system.message' ? ManagedAgentsSystemMessageEventParams : ManagedAgentsUserMessageEventParams|ManagedAgentsUserInterruptEventParams|ManagedAgentsUserToolConfirmationEventParams|ManagedAgentsUserCustomToolResultEventParams|ManagedAgentsUserDefineOutcomeEventParams|ManagedAgentsUserToolResultEventParams|ManagedAgentsSystemMessageEventParams)))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $content = null,
        ?string $sessionThreadID = null,
        Result|string|null $result = null,
        ?string $toolUseID = null,
        ?string $denyMessage = null,
        ?string $customToolUseID = null,
        ?bool $isError = null,
        ?string $description = null,
        ManagedAgentsFileRubricParams|array|ManagedAgentsTextRubricParams|null $rubric = null,
        ?int $maxIterations = null,
    ): ManagedAgentsUserMessageEventParams|ManagedAgentsUserInterruptEventParams|ManagedAgentsUserToolConfirmationEventParams|ManagedAgentsUserCustomToolResultEventParams|ManagedAgentsUserDefineOutcomeEventParams|ManagedAgentsUserToolResultEventParams|ManagedAgentsSystemMessageEventParams {
        return match ($type) {
            Type::USER_MESSAGE, 'user.message' => ManagedAgentsUserMessageEventParams::with(
                type: 'user.message',
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            Type::USER_INTERRUPT, 'user.interrupt' => ManagedAgentsUserInterruptEventParams::with(
                type: 'user.interrupt',
                sessionThreadID: $sessionThreadID
            ),
            Type::USER_TOOL_CONFIRMATION, 'user.tool_confirmation' => ManagedAgentsUserToolConfirmationEventParams::with(
                type: 'user.tool_confirmation',
                result: $result ?? throw new \ArgumentCountError('$result is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                denyMessage: $denyMessage,
            ),
            Type::USER_CUSTOM_TOOL_RESULT, 'user.custom_tool_result' => ManagedAgentsUserCustomToolResultEventParams::with(
                type: 'user.custom_tool_result',
                customToolUseID: $customToolUseID ?? throw new \ArgumentCountError('$customToolUseID is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
            ),
            Type::USER_DEFINE_OUTCOME, 'user.define_outcome' => ManagedAgentsUserDefineOutcomeEventParams::with(
                type: 'user.define_outcome',
                description: $description ?? throw new \ArgumentCountError('$description is required'),
                rubric: $rubric ?? throw new \ArgumentCountError('$rubric is required'),
                maxIterations: $maxIterations,
            ),
            Type::USER_TOOL_RESULT, 'user.tool_result' => ManagedAgentsUserToolResultEventParams::with(
                type: 'user.tool_result',
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
            ),
            Type::SYSTEM_MESSAGE, 'system.message' => ManagedAgentsSystemMessageEventParams::with(
                type: 'system.message',
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
