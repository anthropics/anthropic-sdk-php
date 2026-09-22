<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The server judged the invocation safe to execute without client approval.
 *
 * @phpstan-type ManagedAgentsAgentAutoEvaluatedPermissionAllowShape = array{
 *   type: 'allow'
 * }
 */
final class ManagedAgentsAgentAutoEvaluatedPermissionAllow implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentAutoEvaluatedPermissionAllowShape> */
    use SdkModel;

    /** @var 'allow' $type */
    #[Required(type: new ConstantOf('allow'))]
    public string $type = 'allow';

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
     * @param 'allow' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
