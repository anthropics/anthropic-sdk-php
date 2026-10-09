<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No run was created, because the session was at its limit of open workflow runs, which are runs that have not ended. Only `workflow_run.error` carries this type.
 *
 * @phpstan-type ManagedAgentsMaxWorkflowRunsWorkflowRunErrorShape = array{
 *   message: string, type: 'max_workflow_runs_error'
 * }
 */
final class ManagedAgentsMaxWorkflowRunsWorkflowRunError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMaxWorkflowRunsWorkflowRunErrorShape> */
    use SdkModel;

    /** @var 'max_workflow_runs_error' $type */
    #[Required(type: new ConstantOf('max_workflow_runs_error'))]
    public string $type = 'max_workflow_runs_error';

    /**
     * Short explanation written by the server. It never contains content from the run or its agents.
     */
    #[Required]
    public string $message;

    /**
     * `new ManagedAgentsMaxWorkflowRunsWorkflowRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMaxWorkflowRunsWorkflowRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMaxWorkflowRunsWorkflowRunError())->withMessage(...)
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
     * @param 'max_workflow_runs_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
