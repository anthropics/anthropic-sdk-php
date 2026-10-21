<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Low effort. Favors latency over reasoning depth.
 *
 * @phpstan-type BetaManagedAgentsEffortLowShape = array{type: 'low'}
 */
final class BetaManagedAgentsEffortLow implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsEffortLowShape> */
    use SdkModel;

    /** @var 'low' $type */
    #[Required(type: new ConstantOf('low'))]
    public string $type = 'low';

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
     * @param 'low' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
