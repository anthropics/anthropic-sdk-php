<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The run failed or reached its time limit.
 *
 * @phpstan-import-type ManagedAgentsWorkflowRunErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunErrorObject
 * @phpstan-import-type ManagedAgentsWorkflowRunErrorObjectVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunErrorObject
 *
 * @phpstan-type ManagedAgentsWorkflowRunResultErrorObjectShape = array{
 *   error: ManagedAgentsWorkflowRunErrorObjectShape, type: 'error'
 * }
 */
class ManagedAgentsWorkflowRunResultErrorObject implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunResultErrorObjectShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Required(type: new ConstantOf('error'))]
    public string $type = 'error';

    /**
     * Why the run did not finish.
     *
     * @var ManagedAgentsWorkflowRunErrorObjectVariants $error
     */
    #[Required(union: ManagedAgentsWorkflowRunErrorObject::class)]
    public ManagedAgentsTimeoutWorkflowRunErrorObject|ManagedAgentsProgramWorkflowRunErrorObject|ManagedAgentsUnknownWorkflowRunErrorObject|ManagedAgentsThreadLimitWorkflowRunErrorObject|ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObject $error;

    /**
     * `new ManagedAgentsWorkflowRunResultErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunResultErrorObject::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunResultErrorObject())->withError(...)
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
     * @param ManagedAgentsWorkflowRunErrorObjectShape $error
     */
    public static function with(
        ManagedAgentsTimeoutWorkflowRunErrorObject|array|ManagedAgentsProgramWorkflowRunErrorObject|ManagedAgentsUnknownWorkflowRunErrorObject|ManagedAgentsThreadLimitWorkflowRunErrorObject|ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObject $error,
    ): self {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * Why the run did not finish.
     *
     * @param ManagedAgentsWorkflowRunErrorObjectShape $error
     */
    public function withError(
        ManagedAgentsTimeoutWorkflowRunErrorObject|array|ManagedAgentsProgramWorkflowRunErrorObject|ManagedAgentsUnknownWorkflowRunErrorObject|ManagedAgentsThreadLimitWorkflowRunErrorObject|ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObject $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * @param 'error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    ManagedAgentsWorkflowRunResultErrorObject::class,
    'Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResultError',
);
