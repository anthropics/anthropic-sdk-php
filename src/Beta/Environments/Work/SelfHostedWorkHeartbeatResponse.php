<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Beta\Environments\Work\SelfHostedWorkHeartbeatResponse\State;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Response after recording a heartbeat for a work item.
 *
 * @phpstan-type SelfHostedWorkHeartbeatResponseShape = array{
 *   lastHeartbeat: string,
 *   leaseExtended: bool,
 *   state: State|value-of<State>,
 *   ttlSeconds: int,
 *   type: 'work_heartbeat',
 * }
 */
final class SelfHostedWorkHeartbeatResponse implements BaseModel
{
    /** @use SdkModel<SelfHostedWorkHeartbeatResponseShape> */
    use SdkModel;

    /**
     * The type of response.
     *
     * @var 'work_heartbeat' $type
     */
    #[Required]
    public string $type = 'work_heartbeat';

    /**
     * RFC 3339 timestamp of the actual heartbeat from DB.
     */
    #[Required('last_heartbeat')]
    public string $lastHeartbeat;

    /**
     * Whether the heartbeat succeeded in extending the lease.
     */
    #[Required('lease_extended')]
    public bool $leaseExtended;

    /**
     * Current state of the work item (active/stopping/stopped).
     *
     * @var value-of<State> $state
     */
    #[Required(enum: State::class)]
    public string $state;

    /**
     * Effective TTL applied to the lease.
     */
    #[Required('ttl_seconds')]
    public int $ttlSeconds;

    /**
     * `new SelfHostedWorkHeartbeatResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SelfHostedWorkHeartbeatResponse::with(
     *   lastHeartbeat: ..., leaseExtended: ..., state: ..., ttlSeconds: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SelfHostedWorkHeartbeatResponse)
     *   ->withLastHeartbeat(...)
     *   ->withLeaseExtended(...)
     *   ->withState(...)
     *   ->withTTLSeconds(...)
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
     * @param State|value-of<State> $state
     */
    public static function with(
        string $lastHeartbeat,
        bool $leaseExtended,
        State|string $state,
        int $ttlSeconds,
    ): self {
        $self = new self;

        $self['lastHeartbeat'] = $lastHeartbeat;
        $self['leaseExtended'] = $leaseExtended;
        $self['state'] = $state;
        $self['ttlSeconds'] = $ttlSeconds;

        return $self;
    }

    /**
     * RFC 3339 timestamp of the actual heartbeat from DB.
     */
    public function withLastHeartbeat(string $lastHeartbeat): self
    {
        $self = clone $this;
        $self['lastHeartbeat'] = $lastHeartbeat;

        return $self;
    }

    /**
     * Whether the heartbeat succeeded in extending the lease.
     */
    public function withLeaseExtended(bool $leaseExtended): self
    {
        $self = clone $this;
        $self['leaseExtended'] = $leaseExtended;

        return $self;
    }

    /**
     * Current state of the work item (active/stopping/stopped).
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
     * Effective TTL applied to the lease.
     */
    public function withTTLSeconds(int $ttlSeconds): self
    {
        $self = clone $this;
        $self['ttlSeconds'] = $ttlSeconds;

        return $self;
    }

    /**
     * The type of response.
     *
     * @param 'work_heartbeat' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
