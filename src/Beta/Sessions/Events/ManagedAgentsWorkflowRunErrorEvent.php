<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A workflow run met an error, or an error kept a run from being created. A run that ends with a `result.type` of `error` emits this event before its `workflow_run.status_ended`, with the same `error`.
 *
 * @phpstan-import-type ManagedAgentsWorkflowRunErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunError
 * @phpstan-import-type ManagedAgentsWorkflowRunErrorVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunError
 *
 * @phpstan-type ManagedAgentsWorkflowRunErrorEventShape = array{
 *   id: string,
 *   error: ManagedAgentsWorkflowRunErrorShape,
 *   processedAt: \DateTimeInterface,
 *   type: 'workflow_run.error',
 *   workflowRunID: string|null,
 * }
 */
final class ManagedAgentsWorkflowRunErrorEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunErrorEventShape> */
    use SdkModel;

    /** @var 'workflow_run.error' $type */
    #[Required(type: new ConstantOf('workflow_run.error'))]
    public string $type = 'workflow_run.error';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Why the run did not finish, or was not created.
     *
     * @var ManagedAgentsWorkflowRunErrorVariants $error
     */
    #[Required(union: ManagedAgentsWorkflowRunError::class)]
    public ManagedAgentsTimeoutWorkflowRunError|ManagedAgentsProgramWorkflowRunError|ManagedAgentsUnknownWorkflowRunError|ManagedAgentsThreadLimitWorkflowRunError|ManagedAgentsMaxWorkflowRunsWorkflowRunError $error;

    /**
     * Timestamp when this event was processed.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Identifier of the run that met the error, or `null` when the error kept a run from being created.
     */
    #[Required('workflow_run_id')]
    public ?string $workflowRunID;

    /**
     * `new ManagedAgentsWorkflowRunErrorEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunErrorEvent::with(
     *   id: ..., error: ..., processedAt: ..., workflowRunID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunErrorEvent())
     *   ->withID(...)
     *   ->withError(...)
     *   ->withProcessedAt(...)
     *   ->withWorkflowRunID(...)
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
     *
     * @param ManagedAgentsWorkflowRunErrorShape $error
     */
    public static function with(
        string $id,
        ManagedAgentsTimeoutWorkflowRunError|array|ManagedAgentsProgramWorkflowRunError|ManagedAgentsUnknownWorkflowRunError|ManagedAgentsThreadLimitWorkflowRunError|ManagedAgentsMaxWorkflowRunsWorkflowRunError $error,
        \DateTimeInterface $processedAt,
        ?string $workflowRunID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['error'] = $error;
        $self['processedAt'] = $processedAt;
        $self['workflowRunID'] = $workflowRunID;

        return $self;
    }

    /**
     * Unique identifier for this event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Why the run did not finish, or was not created.
     *
     * @param ManagedAgentsWorkflowRunErrorShape $error
     */
    public function withError(
        ManagedAgentsTimeoutWorkflowRunError|array|ManagedAgentsProgramWorkflowRunError|ManagedAgentsUnknownWorkflowRunError|ManagedAgentsThreadLimitWorkflowRunError|ManagedAgentsMaxWorkflowRunsWorkflowRunError $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Timestamp when this event was processed.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'workflow_run.error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Identifier of the run that met the error, or `null` when the error kept a run from being created.
     */
    public function withWorkflowRunID(?string $workflowRunID): self
    {
        $self = clone $this;
        $self['workflowRunID'] = $workflowRunID;

        return $self;
    }
}
