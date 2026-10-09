<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent has no advisor.
 *
 * @phpstan-type BetaManagedAgentsMultiagentAdvisorDisabledParamsShape = array{
 *   type: 'disabled'
 * }
 */
final class BetaManagedAgentsMultiagentAdvisorDisabledParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentAdvisorDisabledParamsShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required(type: new ConstantOf('disabled'))]
    public string $type = 'disabled';

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
     * @param 'disabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
