<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The run reached its time limit.
 *
 * @phpstan-type ManagedAgentsTimeoutWorkflowRunErrorShape = array{
 *   message: string, type: 'timeout_error'
 * }
 */
final class ManagedAgentsTimeoutWorkflowRunError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTimeoutWorkflowRunErrorShape> */
    use SdkModel;

    /** @var 'timeout_error' $type */
    #[Required(type: new ConstantOf('timeout_error'))]
    public string $type = 'timeout_error';

    /**
     * Short explanation written by the server. It never contains content from the run or its agents.
     */
    #[Required]
    public string $message;

    /**
     * `new ManagedAgentsTimeoutWorkflowRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTimeoutWorkflowRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTimeoutWorkflowRunError())->withMessage(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * Short explanation written by the server. It never contains content from the run or its agents.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param 'timeout_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
