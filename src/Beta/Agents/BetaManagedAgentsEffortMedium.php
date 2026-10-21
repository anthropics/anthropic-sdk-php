<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Medium effort. Balances latency and reasoning depth.
 *
 * @phpstan-type BetaManagedAgentsEffortMediumShape = array{type: 'medium'}
 */
final class BetaManagedAgentsEffortMedium implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsEffortMediumShape> */
    use SdkModel;

    /** @var 'medium' $type */
    #[Required(type: new ConstantOf('medium'))]
    public string $type = 'medium';

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
     * @param 'medium' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
