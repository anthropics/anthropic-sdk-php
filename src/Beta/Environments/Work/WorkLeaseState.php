<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Beta\Environments\Work\WorkLeaseState\State;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A work item's lease as the server holds it.
 *
 * @phpstan-type WorkLeaseStateShape = array{
 *   lastHeartbeat: string|null,
 *   leaseExtended: bool,
 *   state: State|value-of<State>,
 *   ttlSeconds: int,
 * }
 */
final class WorkLeaseState implements BaseModel
{
    /** @use SdkModel<WorkLeaseStateShape> */
    use SdkModel;

    /**
     * RFC 3339 timestamp of the stored heartbeat, or null if there has been none
     */
    #[Required('last_heartbeat')]
    public ?string $lastHeartbeat;

    /**
     * Always false: a refused heartbeat does not extend the lease
     */
    #[Required('lease_extended')]
    public bool $leaseExtended;

    /**
     * Current state of the work item
     *
     * @var value-of<State> $state
     */
    #[Required(enum: State::class)]
    public string $state;

    /**
     * TTL of the lease
     */
    #[Required('ttl_seconds')]
    public int $ttlSeconds;

    /**
     * `new WorkLeaseState()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkLeaseState::with(
     *   lastHeartbeat: ..., leaseExtended: ..., state: ..., ttlSeconds: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkLeaseState())
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
        ?string $lastHeartbeat,
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
     * RFC 3339 timestamp of the stored heartbeat, or null if there has been none
     */
    public function withLastHeartbeat(?string $lastHeartbeat): self
    {
        $self = clone $this;
        $self['lastHeartbeat'] = $lastHeartbeat;

        return $self;
    }

    /**
     * Always false: a refused heartbeat does not extend the lease
     */
    public function withLeaseExtended(bool $leaseExtended): self
    {
        $self = clone $this;
        $self['leaseExtended'] = $leaseExtended;

        return $self;
    }

    /**
     * Current state of the work item
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
     * TTL of the lease
     */
    public function withTTLSeconds(int $ttlSeconds): self
    {
        $self = clone $this;
        $self['ttlSeconds'] = $ttlSeconds;

        return $self;
    }
}
