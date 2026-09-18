<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The resolved permission_policy was always_allow; accompanies evaluated_permission "allow".
 *
 * @phpstan-type ManagedAgentsAgentToolEvaluationAlwaysAllowShape = array{
 *   type: 'always_allow'
 * }
 */
final class ManagedAgentsAgentToolEvaluationAlwaysAllow implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentToolEvaluationAlwaysAllowShape> */
    use SdkModel;

    /** @var 'always_allow' $type */
    #[Required(type: new ConstantOf('always_allow'))]
    public string $type = 'always_allow';

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
     * @param 'always_allow' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
