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
 * @phpstan-import-type ManagedAgentsWorkflowRunErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunError
 * @phpstan-import-type ManagedAgentsWorkflowRunErrorVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunError
 *
 * @phpstan-type ManagedAgentsWorkflowRunResultErrorShape = array{
 *   error: ManagedAgentsWorkflowRunErrorShape, type: 'error'
 * }
 */
final class ManagedAgentsWorkflowRunResultError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunResultErrorShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Required(type: new ConstantOf('error'))]
    public string $type = 'error';

    /**
     * Why the run did not finish.
     *
     * @var ManagedAgentsWorkflowRunErrorVariants $error
     */
    #[Required(union: ManagedAgentsWorkflowRunError::class)]
    public ManagedAgentsTimeoutWorkflowRunError|ManagedAgentsProgramWorkflowRunError|ManagedAgentsUnknownWorkflowRunError|ManagedAgentsThreadLimitWorkflowRunError|ManagedAgentsMaxWorkflowRunsWorkflowRunError $error;

    /**
     * `new ManagedAgentsWorkflowRunResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunResultError::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunResultError())->withError(...)
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
        ManagedAgentsTimeoutWorkflowRunError|array|ManagedAgentsProgramWorkflowRunError|ManagedAgentsUnknownWorkflowRunError|ManagedAgentsThreadLimitWorkflowRunError|ManagedAgentsMaxWorkflowRunsWorkflowRunError $error,
    ): self {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * Why the run did not finish.
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
     * @param 'error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
