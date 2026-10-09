<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent stopped the run.
 *
 * @phpstan-type ManagedAgentsWorkflowRunResultStoppedShape = array{
 *   type: 'stopped'
 * }
 */
final class ManagedAgentsWorkflowRunResultStopped implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunResultStoppedShape> */
    use SdkModel;

    /** @var 'stopped' $type */
    #[Required(type: new ConstantOf('stopped'))]
    public string $type = 'stopped';

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
     * @param 'stopped' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
