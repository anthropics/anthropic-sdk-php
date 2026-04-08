<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsSession\Status;
use Anthropic\Beta\Sessions\BetaManagedAgentsSession\Type;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsSessionResource;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A Managed Agents `session`.
 *
 * @phpstan-import-type ManagedAgentsSessionResourceVariants from \Anthropic\Beta\Sessions\Resources\ManagedAgentsSessionResource
 * @phpstan-import-type BetaManagedAgentsSessionAgentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent
 * @phpstan-import-type ManagedAgentsSessionResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsSessionResource
 * @phpstan-import-type BetaManagedAgentsSessionStatsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionStats
 * @phpstan-import-type BetaManagedAgentsSessionUsageShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionUsage
 *
 * @phpstan-type BetaManagedAgentsSessionShape = array{
 *   id: string,
 *   agent: BetaManagedAgentsSessionAgent|BetaManagedAgentsSessionAgentShape,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   environmentID: string,
 *   metadata: array<string,string>,
 *   resources: list<ManagedAgentsSessionResourceShape>,
 *   stats: BetaManagedAgentsSessionStats|BetaManagedAgentsSessionStatsShape,
 *   status: Status|value-of<Status>,
 *   title: string|null,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   usage: BetaManagedAgentsSessionUsage|BetaManagedAgentsSessionUsageShape,
 *   vaultIDs: list<string>,
 * }
 */
final class BetaManagedAgentsSession implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Resolved `agent` definition for a `session`. Snapshot of the `agent` at `session` creation time.
     */
    #[Required]
    public BetaManagedAgentsSessionAgent $agent;

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

    #[Required('environment_id')]
    public string $environmentID;

    /** @var array<string,string> $metadata */
    #[Required(map: 'string')]
    public array $metadata;

    /** @var list<ManagedAgentsSessionResourceVariants> $resources */
    #[Required(list: ManagedAgentsSessionResource::class)]
    public array $resources;

    /**
     * Timing statistics for a session.
     */
    #[Required]
    public BetaManagedAgentsSessionStats $stats;

    /**
     * SessionStatus enum.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public ?string $title;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Cumulative token usage for a session across all turns.
     */
    #[Required]
    public BetaManagedAgentsSessionUsage $usage;

    /**
     * Vault IDs attached to the session at creation. Empty when no vaults were supplied.
     *
     * @var list<string> $vaultIDs
     */
    #[Required('vault_ids', list: 'string')]
    public array $vaultIDs;

    /**
     * `new BetaManagedAgentsSession()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSession::with(
     *   id: ...,
     *   agent: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   environmentID: ...,
     *   metadata: ...,
     *   resources: ...,
     *   stats: ...,
     *   status: ...,
     *   title: ...,
     *   type: ...,
     *   updatedAt: ...,
     *   usage: ...,
     *   vaultIDs: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSession)
     *   ->withID(...)
     *   ->withAgent(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withEnvironmentID(...)
     *   ->withMetadata(...)
     *   ->withResources(...)
     *   ->withStats(...)
     *   ->withStatus(...)
     *   ->withTitle(...)
     *   ->withType(...)
     *   ->withUpdatedAt(...)
     *   ->withUsage(...)
     *   ->withVaultIDs(...)
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
     * @param BetaManagedAgentsSessionAgent|BetaManagedAgentsSessionAgentShape $agent
     * @param array<string,string> $metadata
     * @param list<ManagedAgentsSessionResourceShape> $resources
     * @param BetaManagedAgentsSessionStats|BetaManagedAgentsSessionStatsShape $stats
     * @param Status|value-of<Status> $status
     * @param Type|value-of<Type> $type
     * @param BetaManagedAgentsSessionUsage|BetaManagedAgentsSessionUsageShape $usage
     * @param list<string> $vaultIDs
     */
    public static function with(
        string $id,
        BetaManagedAgentsSessionAgent|array $agent,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        string $environmentID,
        array $metadata,
        array $resources,
        BetaManagedAgentsSessionStats|array $stats,
        Status|string $status,
        ?string $title,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        BetaManagedAgentsSessionUsage|array $usage,
        array $vaultIDs,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agent'] = $agent;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['environmentID'] = $environmentID;
        $self['metadata'] = $metadata;
        $self['resources'] = $resources;
        $self['stats'] = $stats;
        $self['status'] = $status;
        $self['title'] = $title;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;
        $self['usage'] = $usage;
        $self['vaultIDs'] = $vaultIDs;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Resolved `agent` definition for a `session`. Snapshot of the `agent` at `session` creation time.
     *
     * @param BetaManagedAgentsSessionAgent|BetaManagedAgentsSessionAgentShape $agent
     */
    public function withAgent(BetaManagedAgentsSessionAgent|array $agent): self
    {
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

    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * @param list<ManagedAgentsSessionResourceShape> $resources
     */
    public function withResources(array $resources): self
    {
        $self = clone $this;
        $self['resources'] = $resources;

        return $self;
    }

    /**
     * Timing statistics for a session.
     *
     * @param BetaManagedAgentsSessionStats|BetaManagedAgentsSessionStatsShape $stats
     */
    public function withStats(BetaManagedAgentsSessionStats|array $stats): self
    {
        $self = clone $this;
        $self['stats'] = $stats;

        return $self;
    }

    /**
     * SessionStatus enum.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

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
     * Cumulative token usage for a session across all turns.
     *
     * @param BetaManagedAgentsSessionUsage|BetaManagedAgentsSessionUsageShape $usage
     */
    public function withUsage(BetaManagedAgentsSessionUsage|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }

    /**
     * Vault IDs attached to the session at creation. Empty when no vaults were supplied.
     *
     * @param list<string> $vaultIDs
     */
    public function withVaultIDs(array $vaultIDs): self
    {
        $self = clone $this;
        $self['vaultIDs'] = $vaultIDs;

        return $self;
    }
}
