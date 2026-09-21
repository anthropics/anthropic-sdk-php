<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionBudgetReached;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEndTurn;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRequiresAction;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRetriesExhausted;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent\StopReason\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsSessionEndTurnShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEndTurn
 * @phpstan-import-type ManagedAgentsSessionRequiresActionShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRequiresAction
 * @phpstan-import-type ManagedAgentsSessionRetriesExhaustedShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRetriesExhausted
 * @phpstan-import-type ManagedAgentsSessionBudgetReachedShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionBudgetReached
 *
 * @phpstan-type StopReasonVariants = ManagedAgentsSessionEndTurn|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted|ManagedAgentsSessionBudgetReached
 * @phpstan-type StopReasonShape = StopReasonVariants|ManagedAgentsSessionEndTurnShape|ManagedAgentsSessionRequiresActionShape|ManagedAgentsSessionRetriesExhaustedShape|ManagedAgentsSessionBudgetReachedShape
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
            'budget_reached' => ManagedAgentsSessionBudgetReached::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<string>|null $eventIDs
     *
     * @return ($type is Type::END_TURN|'end_turn' ? ManagedAgentsSessionEndTurn : ($type is Type::REQUIRES_ACTION|'requires_action' ? ManagedAgentsSessionRequiresAction : ($type is Type::RETRIES_EXHAUSTED|'retries_exhausted' ? ManagedAgentsSessionRetriesExhausted : ($type is Type::BUDGET_REACHED|'budget_reached' ? ManagedAgentsSessionBudgetReached : ManagedAgentsSessionEndTurn|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted|ManagedAgentsSessionBudgetReached))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $eventIDs = null,
    ): ManagedAgentsSessionEndTurn|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted|ManagedAgentsSessionBudgetReached {
        return match ($type) {
            Type::END_TURN, 'end_turn' => ManagedAgentsSessionEndTurn::with(
                type: 'end_turn'
            ),
            Type::REQUIRES_ACTION, 'requires_action' => ManagedAgentsSessionRequiresAction::with(
                type: 'requires_action',
                eventIDs: $eventIDs ?? throw new \ArgumentCountError('$eventIDs is required'),
            ),
            Type::RETRIES_EXHAUSTED, 'retries_exhausted' => ManagedAgentsSessionRetriesExhausted::with(
                type: 'retries_exhausted'
            ),
            Type::BUDGET_REACHED, 'budget_reached' => ManagedAgentsSessionBudgetReached::with(
                type: 'budget_reached'
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
