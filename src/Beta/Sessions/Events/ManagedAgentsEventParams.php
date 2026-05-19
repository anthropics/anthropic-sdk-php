<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

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
 *
 * @phpstan-type ManagedAgentsEventParamsVariants = ManagedAgentsUserMessageEventParams|ManagedAgentsUserInterruptEventParams|ManagedAgentsUserToolConfirmationEventParams|ManagedAgentsUserCustomToolResultEventParams|ManagedAgentsUserDefineOutcomeEventParams|ManagedAgentsUserToolResultEventParams
 * @phpstan-type ManagedAgentsEventParamsShape = ManagedAgentsEventParamsVariants|ManagedAgentsUserMessageEventParamsShape|ManagedAgentsUserInterruptEventParamsShape|ManagedAgentsUserToolConfirmationEventParamsShape|ManagedAgentsUserCustomToolResultEventParamsShape|ManagedAgentsUserDefineOutcomeEventParamsShape|ManagedAgentsUserToolResultEventParamsShape
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
        ];
    }
}
