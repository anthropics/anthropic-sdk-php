<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The run exceeded the limit on the number of threads that a run can create.
 *
 * @phpstan-type ManagedAgentsThreadLimitWorkflowRunErrorShape = array{
 *   message: string, type: 'thread_limit_error'
 * }
 */
final class ManagedAgentsThreadLimitWorkflowRunError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsThreadLimitWorkflowRunErrorShape> */
    use SdkModel;

    /** @var 'thread_limit_error' $type */
    #[Required(type: new ConstantOf('thread_limit_error'))]
    public string $type = 'thread_limit_error';

    /**
     * Short explanation written by the server. It never contains content from the run or its agents.
     */
    #[Required]
    public string $message;

    /**
     * `new ManagedAgentsThreadLimitWorkflowRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsThreadLimitWorkflowRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsThreadLimitWorkflowRunError())->withMessage(...)
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
     * @param 'thread_limit_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
