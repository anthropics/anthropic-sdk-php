<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEndTurn;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRequiresAction;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRetriesExhausted;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The agent completed its turn naturally and is ready for the next user message.
 *
 * @phpstan-import-type ManagedAgentsSessionEndTurnShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEndTurn
 * @phpstan-import-type ManagedAgentsSessionRequiresActionShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRequiresAction
 * @phpstan-import-type ManagedAgentsSessionRetriesExhaustedShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRetriesExhausted
 *
 * @phpstan-type StopReasonVariants = ManagedAgentsSessionEndTurn|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted
 * @phpstan-type StopReasonShape = StopReasonVariants|ManagedAgentsSessionEndTurnShape|ManagedAgentsSessionRequiresActionShape|ManagedAgentsSessionRetriesExhaustedShape
 */
final class StopReason implements ConverterSource
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
            'end_turn' => ManagedAgentsSessionEndTurn::class,
            'requires_action' => ManagedAgentsSessionRequiresAction::class,
            'retries_exhausted' => ManagedAgentsSessionRetriesExhausted::class,
        ];
    }
}
