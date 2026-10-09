<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The plan, a program that the agent wrote, failed, or the server refused it.
 *
 * @phpstan-type ManagedAgentsProgramWorkflowRunErrorShape = array{
 *   message: string, type: 'program_error'
 * }
 */
final class ManagedAgentsProgramWorkflowRunError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsProgramWorkflowRunErrorShape> */
    use SdkModel;

    /** @var 'program_error' $type */
    #[Required(type: new ConstantOf('program_error'))]
    public string $type = 'program_error';

    /**
     * Short explanation written by the server. It never contains content from the run or its agents.
     */
    #[Required]
    public string $message;

    /**
     * `new ManagedAgentsProgramWorkflowRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsProgramWorkflowRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsProgramWorkflowRunError())->withMessage(...)
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
     * @param 'program_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
