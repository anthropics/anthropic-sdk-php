<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * High effort. Favors reasoning depth.
 *
 * @phpstan-type BetaManagedAgentsEffortHighShape = array{type: 'high'}
 */
final class BetaManagedAgentsEffortHigh implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsEffortHighShape> */
    use SdkModel;

    /** @var 'high' $type */
    #[Required(type: new ConstantOf('high'))]
    public string $type = 'high';

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
     * @param 'high' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
