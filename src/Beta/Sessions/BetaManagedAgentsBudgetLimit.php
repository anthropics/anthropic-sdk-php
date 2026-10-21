<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\BetaMonetaryAmount;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A hard spend ceiling. The session stops issuing new model requests once the tracked list cost reaches `max_list_cost`.
 *
 * @phpstan-import-type BetaMonetaryAmountShape from \Anthropic\Beta\BetaMonetaryAmount
 *
 * @phpstan-type BetaManagedAgentsBudgetLimitShape = array{
 *   maxListCost: BetaMonetaryAmount|BetaMonetaryAmountShape, type: 'limit'
 * }
 */
final class BetaManagedAgentsBudgetLimit implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsBudgetLimitShape> */
    use SdkModel;

    /** @var 'limit' $type */
    #[Required(type: new ConstantOf('limit'))]
    public string $type = 'limit';

    /**
     * Maximum list cost the session may accrue. List price is used regardless of any negotiated discount, so the cap fires at or before the actual charge.
     */
    #[Required('max_list_cost')]
    public BetaMonetaryAmount $maxListCost;

    /**
     * `new BetaManagedAgentsBudgetLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsBudgetLimit::with(maxListCost: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsBudgetLimit())->withMaxListCost(...)
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
     */
    public static function with(BetaMonetaryAmount|array $maxListCost): self
    {
        $self = new self;

        $self['maxListCost'] = $maxListCost;

        return $self;
    }

    /**
     * Maximum list cost the session may accrue. List price is used regardless of any negotiated discount, so the cap fires at or before the actual charge.
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
     * @param 'limit' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
