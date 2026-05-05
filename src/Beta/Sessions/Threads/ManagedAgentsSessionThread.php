<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads;

use Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An execution thread within a `session`. Each session has one primary thread plus zero or more child threads spawned by the coordinator.
 *
 * @phpstan-import-type ManagedAgentsSessionThreadAgentShape from \Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThreadAgent
 * @phpstan-import-type ManagedAgentsSessionThreadStatsShape from \Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThreadStats
 * @phpstan-import-type ManagedAgentsSessionThreadUsageShape from \Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThreadUsage
 *
 * @phpstan-type ManagedAgentsSessionThreadShape = array{
 *   id: string,
 *   agent: ManagedAgentsSessionThreadAgent|ManagedAgentsSessionThreadAgentShape,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   parentThreadID: string|null,
 *   sessionID: string,
 *   stats: null|ManagedAgentsSessionThreadStats|ManagedAgentsSessionThreadStatsShape,
 *   status: ManagedAgentsSessionThreadStatus|value-of<ManagedAgentsSessionThreadStatus>,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   usage: null|ManagedAgentsSessionThreadUsage|ManagedAgentsSessionThreadUsageShape,
 * }
 */
final class ManagedAgentsSessionThread implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionThreadShape> */
    use SdkModel;

    /**
     * Unique identifier for this thread.
     */
    #[Required]
    public string $id;

    /**
     * Resolved `agent` definition for a single `session_thread`. Snapshot of the agent at thread creation time. The multiagent roster is not repeated here; read it from `Session.agent`.
     */
    #[Required]
    public ManagedAgentsSessionThreadAgent $agent;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Parent thread that spawned this thread. Null for the primary thread.
     */
    #[Required('parent_thread_id')]
    public ?string $parentThreadID;

    /**
     * The session this thread belongs to.
     */
    #[Required('session_id')]
    public string $sessionID;

    /**
     * Timing statistics for a session thread.
     */
    #[Required]
    public ?ManagedAgentsSessionThreadStats $stats;

    /**
     * SessionThreadStatus enum.
     *
     * @var value-of<ManagedAgentsSessionThreadStatus> $status
     */
    #[Required(enum: ManagedAgentsSessionThreadStatus::class)]
    public string $status;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Cumulative token usage for a session thread across all turns.
     */
    #[Required]
    public ?ManagedAgentsSessionThreadUsage $usage;

    /**
     * `new ManagedAgentsSessionThread()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionThread::with(
     *   id: ...,
     *   agent: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   parentThreadID: ...,
     *   sessionID: ...,
     *   stats: ...,
     *   status: ...,
     *   type: ...,
     *   updatedAt: ...,
     *   usage: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionThread)
     *   ->withID(...)
     *   ->withAgent(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withParentThreadID(...)
     *   ->withSessionID(...)
     *   ->withStats(...)
     *   ->withStatus(...)
     *   ->withType(...)
     *   ->withUpdatedAt(...)
     *   ->withUsage(...)
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
     * @param ManagedAgentsSessionThreadAgent|ManagedAgentsSessionThreadAgentShape $agent
     * @param ManagedAgentsSessionThreadStats|ManagedAgentsSessionThreadStatsShape|null $stats
     * @param ManagedAgentsSessionThreadStatus|value-of<ManagedAgentsSessionThreadStatus> $status
     * @param Type|value-of<Type> $type
     * @param ManagedAgentsSessionThreadUsage|ManagedAgentsSessionThreadUsageShape|null $usage
     */
    public static function with(
        string $id,
        ManagedAgentsSessionThreadAgent|array $agent,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        ?string $parentThreadID,
        string $sessionID,
        ManagedAgentsSessionThreadStats|array|null $stats,
        ManagedAgentsSessionThreadStatus|string $status,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        ManagedAgentsSessionThreadUsage|array|null $usage,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agent'] = $agent;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['parentThreadID'] = $parentThreadID;
        $self['sessionID'] = $sessionID;
        $self['stats'] = $stats;
        $self['status'] = $status;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;
        $self['usage'] = $usage;

        return $self;
    }

    /**
     * Unique identifier for this thread.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Resolved `agent` definition for a single `session_thread`. Snapshot of the agent at thread creation time. The multiagent roster is not repeated here; read it from `Session.agent`.
     *
     * @param ManagedAgentsSessionThreadAgent|ManagedAgentsSessionThreadAgentShape $agent
     */
    public function withAgent(
        ManagedAgentsSessionThreadAgent|array $agent
    ): self {
        $self = clone $this;
        $self['agent'] = $agent;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Parent thread that spawned this thread. Null for the primary thread.
     */
    public function withParentThreadID(?string $parentThreadID): self
    {
        $self = clone $this;
        $self['parentThreadID'] = $parentThreadID;

        return $self;
    }

    /**
     * The session this thread belongs to.
     */
    public function withSessionID(string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * Timing statistics for a session thread.
     *
     * @param ManagedAgentsSessionThreadStats|ManagedAgentsSessionThreadStatsShape|null $stats
     */
    public function withStats(
        ManagedAgentsSessionThreadStats|array|null $stats
    ): self {
        $self = clone $this;
        $self['stats'] = $stats;

        return $self;
    }

    /**
     * SessionThreadStatus enum.
     *
     * @param ManagedAgentsSessionThreadStatus|value-of<ManagedAgentsSessionThreadStatus> $status
     */
    public function withStatus(
        ManagedAgentsSessionThreadStatus|string $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Cumulative token usage for a session thread across all turns.
     *
     * @param ManagedAgentsSessionThreadUsage|ManagedAgentsSessionThreadUsageShape|null $usage
     */
    public function withUsage(
        ManagedAgentsSessionThreadUsage|array|null $usage
    ): self {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
