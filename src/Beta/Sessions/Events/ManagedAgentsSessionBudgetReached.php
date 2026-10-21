<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent stopped because the session's tracked list cost reached its budget, or because its usage includes a model with no list price (which the budget cannot measure). Raise the budget to continue — or, if raising is rejected because a model has no list price, remove the budget.
 *
 * @phpstan-type ManagedAgentsSessionBudgetReachedShape = array{
 *   type: 'budget_reached'
 * }
 */
final class ManagedAgentsSessionBudgetReached implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionBudgetReachedShape> */
    use SdkModel;

    /** @var 'budget_reached' $type */
    #[Required(type: new ConstantOf('budget_reached'))]
    public string $type = 'budget_reached';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'budget_reached' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
