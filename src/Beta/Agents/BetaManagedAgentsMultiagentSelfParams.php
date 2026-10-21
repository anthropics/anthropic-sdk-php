<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Sentinel roster entry meaning "the agent that owns this configuration". Resolved server-side to a concrete agent reference.
 *
 * @phpstan-type BetaManagedAgentsMultiagentSelfParamsShape = array{type: 'self'}
 */
final class BetaManagedAgentsMultiagentSelfParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentSelfParamsShape> */
    use SdkModel;

    /** @var 'self' $type */
    #[Required(type: new ConstantOf('self'))]
    public string $type = 'self';

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
     * @param 'self' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
