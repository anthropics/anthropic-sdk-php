<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type SpendLimitSeatTierScopeShape = array{
 *   seatTier: string, type: 'seat_tier'
 * }
 */
final class SpendLimitSeatTierScope implements BaseModel
{
    /** @use SdkModel<SpendLimitSeatTierScopeShape> */
    use SdkModel;

    /** @var 'seat_tier' $type */
    #[Required(type: new ConstantOf('seat_tier'))]
    public string $type = 'seat_tier';

    #[Required('seat_tier')]
    public string $seatTier;

    /**
     * `new SpendLimitSeatTierScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitSeatTierScope::with(seatTier: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitSeatTierScope())->withSeatTier(...)
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
     */
    public static function with(string $seatTier): self
    {
        $self = new self;

        $self['seatTier'] = $seatTier;

        return $self;
    }

    public function withSeatTier(string $seatTier): self
    {
        $self = clone $this;
        $self['seatTier'] = $seatTier;

        return $self;
    }

    /**
     * @param 'seat_tier' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
