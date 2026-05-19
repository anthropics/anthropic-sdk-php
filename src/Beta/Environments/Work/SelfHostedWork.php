<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Beta\Environments\Work\SelfHostedWork\State;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Work resource representing a unit of work in a self-hosted environment.
 *
 * Work items are queued when sessions are created or when long-dormant sessions
 * receive new messages. The environment worker polls for work to execute in a
 * self-hosted sandbox.
 *
 * @phpstan-import-type SessionWorkDataShape from \Anthropic\Beta\Environments\Work\SessionWorkData
 *
 * @phpstan-type SelfHostedWorkShape = array{
 *   id: string,
 *   acknowledgedAt: string|null,
 *   createdAt: string,
 *   data: SessionWorkData|SessionWorkDataShape,
 *   environmentID: string,
 *   latestHeartbeatAt: string|null,
 *   metadata: array<string,string>,
 *   startedAt: string|null,
 *   state: State|value-of<State>,
 *   stopRequestedAt: string|null,
 *   stoppedAt: string|null,
 *   type: 'work',
 * }
 */
final class SelfHostedWork implements BaseModel
{
    /** @use SdkModel<SelfHostedWorkShape> */
    use SdkModel;

    /**
     * The type of object (always 'work').
     *
     * @var 'work' $type
     */
    #[Required]
    public string $type = 'work';

    /**
     * Work identifier (e.g., 'work_...').
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 timestamp when the work item was acknowledged and assigned to a self-hosted sandbox.
     */
    #[Required('acknowledged_at')]
    public ?string $acknowledgedAt;

    /**
     * RFC 3339 timestamp when work was created.
     */
    #[Required('created_at')]
    public string $createdAt;

    /**
     * The actual work to be performed.
     */
    #[Required]
    public SessionWorkData $data;

    /**
     * Environment identifier this work belongs to (e.g., `env_...`).
     */
    #[Required('environment_id')]
    public string $environmentID;

    /**
     * RFC 3339 timestamp of the most recent heartbeat.
     */
    #[Required('latest_heartbeat_at')]
    public ?string $latestHeartbeatAt;

    /**
     * User-provided metadata key-value pairs associated with this work item.
     *
     * @var array<string,string> $metadata
     */
    #[Required(map: 'string')]
    public array $metadata;

    /**
     * RFC 3339 timestamp when work execution started.
     */
    #[Required('started_at')]
    public ?string $startedAt;

    /**
     * Current state of the work item.
     *
     * @var value-of<State> $state
     */
    #[Required(enum: State::class)]
    public string $state;

    /**
     * RFC 3339 timestamp when stop was requested.
     */
    #[Required('stop_requested_at')]
    public ?string $stopRequestedAt;

    /**
     * RFC 3339 timestamp when work execution stopped.
     */
    #[Required('stopped_at')]
    public ?string $stoppedAt;

    /**
     * `new SelfHostedWork()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SelfHostedWork::with(
     *   id: ...,
     *   acknowledgedAt: ...,
     *   createdAt: ...,
     *   data: ...,
     *   environmentID: ...,
     *   latestHeartbeatAt: ...,
     *   metadata: ...,
     *   startedAt: ...,
     *   state: ...,
     *   stopRequestedAt: ...,
     *   stoppedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SelfHostedWork)
     *   ->withID(...)
     *   ->withAcknowledgedAt(...)
     *   ->withCreatedAt(...)
     *   ->withData(...)
     *   ->withEnvironmentID(...)
     *   ->withLatestHeartbeatAt(...)
     *   ->withMetadata(...)
     *   ->withStartedAt(...)
     *   ->withState(...)
     *   ->withStopRequestedAt(...)
     *   ->withStoppedAt(...)
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
     * @param SessionWorkData|SessionWorkDataShape $data
     * @param array<string,string> $metadata
     * @param State|value-of<State> $state
     */
    public static function with(
        string $id,
        ?string $acknowledgedAt,
        string $createdAt,
        SessionWorkData|array $data,
        string $environmentID,
        ?string $latestHeartbeatAt,
        array $metadata,
        ?string $startedAt,
        State|string $state,
        ?string $stopRequestedAt,
        ?string $stoppedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['acknowledgedAt'] = $acknowledgedAt;
        $self['createdAt'] = $createdAt;
        $self['data'] = $data;
        $self['environmentID'] = $environmentID;
        $self['latestHeartbeatAt'] = $latestHeartbeatAt;
        $self['metadata'] = $metadata;
        $self['startedAt'] = $startedAt;
        $self['state'] = $state;
        $self['stopRequestedAt'] = $stopRequestedAt;
        $self['stoppedAt'] = $stoppedAt;

        return $self;
    }

    /**
     * Work identifier (e.g., 'work_...').
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 timestamp when the work item was acknowledged and assigned to a self-hosted sandbox.
     */
    public function withAcknowledgedAt(?string $acknowledgedAt): self
    {
        $self = clone $this;
        $self['acknowledgedAt'] = $acknowledgedAt;

        return $self;
    }

    /**
     * RFC 3339 timestamp when work was created.
     */
    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The actual work to be performed.
     *
     * @param SessionWorkData|SessionWorkDataShape $data
     */
    public function withData(SessionWorkData|array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Environment identifier this work belongs to (e.g., `env_...`).
     */
    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * RFC 3339 timestamp of the most recent heartbeat.
     */
    public function withLatestHeartbeatAt(?string $latestHeartbeatAt): self
    {
        $self = clone $this;
        $self['latestHeartbeatAt'] = $latestHeartbeatAt;

        return $self;
    }

    /**
     * User-provided metadata key-value pairs associated with this work item.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * RFC 3339 timestamp when work execution started.
     */
    public function withStartedAt(?string $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }

    /**
     * Current state of the work item.
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * RFC 3339 timestamp when stop was requested.
     */
    public function withStopRequestedAt(?string $stopRequestedAt): self
    {
        $self = clone $this;
        $self['stopRequestedAt'] = $stopRequestedAt;

        return $self;
    }

    /**
     * RFC 3339 timestamp when work execution stopped.
     */
    public function withStoppedAt(?string $stoppedAt): self
    {
        $self = clone $this;
        $self['stoppedAt'] = $stoppedAt;

        return $self;
    }

    /**
     * The type of object (always 'work').
     *
     * @param 'work' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
