<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent;
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
 *
 * @phpstan-type DataVariants = ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent
 * @phpstan-type DataShape = DataVariants|ManagedAgentsUserMessageEventShape|ManagedAgentsUserInterruptEventShape|ManagedAgentsUserToolConfirmationEventShape|ManagedAgentsUserCustomToolResultEventShape
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
        ];
    }
}
