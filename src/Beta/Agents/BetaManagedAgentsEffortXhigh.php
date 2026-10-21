<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Extra-high effort. Not all models accept this level.
 *
 * @phpstan-type BetaManagedAgentsEffortXhighShape = array{type: 'xhigh'}
 */
final class BetaManagedAgentsEffortXhigh implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsEffortXhighShape> */
    use SdkModel;

    /** @var 'xhigh' $type */
    #[Required(type: new ConstantOf('xhigh'))]
    public string $type = 'xhigh';

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
     * @param 'xhigh' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
