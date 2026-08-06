<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\BetaMonetaryAmount;
use Anthropic\Beta\Sessions\BetaManagedAgentsBudgetLimit\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A hard spend ceiling. The session stops issuing new model requests once the tracked list cost reaches `max_list_cost`.
 *
 * @phpstan-import-type BetaMonetaryAmountShape from \Anthropic\Beta\BetaMonetaryAmount
 *
 * @phpstan-type BetaManagedAgentsBudgetLimitShape = array{
 *   maxListCost: BetaMonetaryAmount|BetaMonetaryAmountShape,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsBudgetLimit implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsBudgetLimitShape> */
    use SdkModel;

    /**
     * A monetary amount in a specific currency.
     */
    #[Required('max_list_cost')]
    public BetaMonetaryAmount $maxListCost;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsBudgetLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsBudgetLimit::with(maxListCost: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsBudgetLimit)->withMaxListCost(...)->withType(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaMonetaryAmount|BetaMonetaryAmountShape $maxListCost
     * @param Type|value-of<Type> $type
     */
    public static function with(
        BetaMonetaryAmount|array $maxListCost,
        Type|string $type
    ): self {
        $self = new self;

        $self['maxListCost'] = $maxListCost;
        $self['type'] = $type;

        return $self;
    }

    /**
     * A monetary amount in a specific currency.
     *
     * @param BetaMonetaryAmount|BetaMonetaryAmountShape $maxListCost
     */
    public function withMaxListCost(BetaMonetaryAmount|array $maxListCost): self
    {
        $self = clone $this;
        $self['maxListCost'] = $maxListCost;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
