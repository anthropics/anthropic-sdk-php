<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Maximum effort. Favors reasoning depth over latency.
 *
 * @phpstan-type BetaManagedAgentsEffortMaxShape = array{type: 'max'}
 */
final class BetaManagedAgentsEffortMax implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsEffortMaxShape> */
    use SdkModel;

    /** @var 'max' $type */
    #[Required(type: new ConstantOf('max'))]
    public string $type = 'max';

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
     * @param 'max' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
