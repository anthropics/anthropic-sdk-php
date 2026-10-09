<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A phase that a workflow run's plan declares.
 *
 * @phpstan-type ManagedAgentsWorkflowRunPhaseShape = array{
 *   id: string, description: string|null, name: string
 * }
 */
final class ManagedAgentsWorkflowRunPhase implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunPhaseShape> */
    use SdkModel;

    /**
     * Unique identifier for the phase.
     */
    #[Required]
    public string $id;

    /**
     * Description that the agent gave the phase, passed on as written, or `null` if it gave none.
     */
    #[Required]
    public ?string $description;

    /**
     * Name that the agent gave the phase, passed on as written.
     */
    #[Required]
    public string $name;

    /**
     * `new ManagedAgentsWorkflowRunPhase()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunPhase::with(id: ..., description: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunPhase())
     *   ->withID(...)
     *   ->withDescription(...)
     *   ->withName(...)
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
    public static function with(
        string $id,
        ?string $description,
        string $name
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['description'] = $description;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Unique identifier for the phase.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Description that the agent gave the phase, passed on as written, or `null` if it gave none.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Name that the agent gave the phase, passed on as written.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
