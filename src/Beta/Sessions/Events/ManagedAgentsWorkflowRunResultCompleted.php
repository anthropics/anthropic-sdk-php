<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The run's plan, a program that the agent wrote, finished. This does not say whether the work succeeded.
 *
 * @phpstan-type ManagedAgentsWorkflowRunResultCompletedShape = array{
 *   type: 'completed'
 * }
 */
final class ManagedAgentsWorkflowRunResultCompleted implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunResultCompletedShape> */
    use SdkModel;

    /** @var 'completed' $type */
    #[Required(type: new ConstantOf('completed'))]
    public string $type = 'completed';

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
     * @param 'completed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
