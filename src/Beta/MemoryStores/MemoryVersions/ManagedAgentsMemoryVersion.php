<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * One entry in a memory's history, recording a single change and who made it.
 *
 * Every change to a memory adds one version. Only redaction can change a version after that. Versions belong to the memory store and stay after the memory is deleted. Each version is retained for at least the version retention period after it was written, unless the store itself is deleted.
 *
 * Retrieving a redacted version succeeds, with `content`, `path`, `content_size_bytes`, and `content_sha256` set to `null`. Check `redacted_at` to find out whether a version was redacted.
 *
 * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#audit-memory-changes) to learn more about memory versions.
 *
 * @phpstan-import-type ManagedAgentsActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsActor
 * @phpstan-import-type ManagedAgentsActorVariants from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsActor
 *
 * @phpstan-type ManagedAgentsMemoryVersionShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   memoryID: string,
 *   memoryStoreID: string,
 *   operation: ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation>,
 *   type: Type|value-of<Type>,
 *   content?: string|null,
 *   contentSha256?: string|null,
 *   contentSizeBytes?: int|null,
 *   createdBy?: ManagedAgentsActorShape|null,
 *   path?: string|null,
 *   redactedAt?: \DateTimeInterface|null,
 *   redactedBy?: ManagedAgentsActorShape|null,
 * }
 */
final class ManagedAgentsMemoryVersion implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMemoryVersionShape> */
    use SdkModel;

    /**
     * Unique identifier for this version (a `memver_...` value).
     */
    #[Required]
    public string $id;

    /**
     * When this version was written, in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The ID of the memory that this version belongs to (`mem_...`).
     *
     * The ID stays valid after the memory is deleted. Pass it as `memory_id` to [List Memory Versions](https://platform.claude.com/docs/en/api/beta/memory_stores/memory_versions/list) to get the memory's retained versions, including its `deleted` version while the lineage is retained.
     */
    #[Required('memory_id')]
    public string $memoryID;

    /**
     * ID of the memory store this version belongs to (a `memstore_...` value).
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * The kind of mutation this version records: `created`, `modified`, or `deleted`.
     *
     * @var value-of<ManagedAgentsMemoryVersionOperation> $operation
     */
    #[Required(enum: ManagedAgentsMemoryVersionOperation::class)]
    public string $operation;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * The memory's UTF-8 text content as of this version. `null` when `view=basic`, when `operation` is `deleted`, or when `redacted_at` is set.
     */
    #[Optional(nullable: true)]
    public ?string $content;

    /**
     * Lowercase hex SHA-256 digest of `content` as of this version (64 characters). `null` when `redacted_at` is set or `operation` is `deleted`. Populated regardless of `view` otherwise.
     */
    #[Optional('content_sha256', nullable: true)]
    public ?string $contentSha256;

    /**
     * Size of `content` in bytes as of this version. `null` when `redacted_at` is set or `operation` is `deleted`. Populated regardless of `view` otherwise.
     */
    #[Optional('content_size_bytes', nullable: true)]
    public ?int $contentSizeBytes;

    /**
     * Who made this change to the memory, or `null` if the author wasn't recorded.
     *
     * Redacting the version doesn't change this field. A `session_actor` here is an agent that wrote through the store's mounted filesystem at `/mnt/memory/`. The version doesn't record the API key that created that session. So the author in `created_by` is who made the change, not who is ultimately responsible for it.
     *
     * You can [retrieve the session](https://platform.claude.com/docs/en/api/beta/sessions/retrieve) to learn more about where the change came from.
     *
     * @var ManagedAgentsActorVariants|null $createdBy
     */
    #[Optional('created_by', union: ManagedAgentsActor::class)]
    public ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor|null $createdBy;

    /**
     * The memory's path at the time of this write. `null` if and only if `redacted_at` is set.
     */
    #[Optional(nullable: true)]
    public ?string $path;

    /**
     * When the version was redacted, in RFC 3339, or `null` if it hasn't been.
     *
     * When set, `content`, `path`, `content_size_bytes`, and `content_sha256` are `null`.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#redact-a-version) to learn more about redaction.
     */
    #[Optional('redacted_at', nullable: true)]
    public ?\DateTimeInterface $redactedAt;

    /**
     * Who redacted this version, or `null` if it has not been redacted. In practice always an `api_actor`, `user_actor`, or `service_account_actor` (agents do not have a redact capability).
     *
     * @var ManagedAgentsActorVariants|null $redactedBy
     */
    #[Optional('redacted_by', union: ManagedAgentsActor::class)]
    public ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor|null $redactedBy;

    /**
     * `new ManagedAgentsMemoryVersion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMemoryVersion::with(
     *   id: ...,
     *   createdAt: ...,
     *   memoryID: ...,
     *   memoryStoreID: ...,
     *   operation: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMemoryVersion())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withMemoryID(...)
     *   ->withMemoryStoreID(...)
     *   ->withOperation(...)
     *   ->withType(...)
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
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation> $operation
     * @param Type|value-of<Type> $type
     * @param ManagedAgentsActorShape|null $createdBy
     * @param ManagedAgentsActorShape|null $redactedBy
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $memoryID,
        string $memoryStoreID,
        ManagedAgentsMemoryVersionOperation|string $operation,
        Type|string $type,
        ?string $content = null,
        ?string $contentSha256 = null,
        ?int $contentSizeBytes = null,
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor|null $createdBy = null,
        ?string $path = null,
        ?\DateTimeInterface $redactedAt = null,
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor|null $redactedBy = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['memoryID'] = $memoryID;
        $self['memoryStoreID'] = $memoryStoreID;
        $self['operation'] = $operation;
        $self['type'] = $type;

        null !== $content && $self['content'] = $content;
        null !== $contentSha256 && $self['contentSha256'] = $contentSha256;
        null !== $contentSizeBytes && $self['contentSizeBytes'] = $contentSizeBytes;
        null !== $createdBy && $self['createdBy'] = $createdBy;
        null !== $path && $self['path'] = $path;
        null !== $redactedAt && $self['redactedAt'] = $redactedAt;
        null !== $redactedBy && $self['redactedBy'] = $redactedBy;

        return $self;
    }

    /**
     * Unique identifier for this version (a `memver_...` value).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When this version was written, in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The ID of the memory that this version belongs to (`mem_...`).
     *
     * The ID stays valid after the memory is deleted. Pass it as `memory_id` to [List Memory Versions](https://platform.claude.com/docs/en/api/beta/memory_stores/memory_versions/list) to get the memory's retained versions, including its `deleted` version while the lineage is retained.
     */
    public function withMemoryID(string $memoryID): self
    {
        $self = clone $this;
        $self['memoryID'] = $memoryID;

        return $self;
    }

    /**
     * ID of the memory store this version belongs to (a `memstore_...` value).
     */
    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * The kind of mutation this version records: `created`, `modified`, or `deleted`.
     *
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation> $operation
     */
    public function withOperation(
        ManagedAgentsMemoryVersionOperation|string $operation
    ): self {
        $self = clone $this;
        $self['operation'] = $operation;

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
     * The memory's UTF-8 text content as of this version. `null` when `view=basic`, when `operation` is `deleted`, or when `redacted_at` is set.
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Lowercase hex SHA-256 digest of `content` as of this version (64 characters). `null` when `redacted_at` is set or `operation` is `deleted`. Populated regardless of `view` otherwise.
     */
    public function withContentSha256(?string $contentSha256): self
    {
        $self = clone $this;
        $self['contentSha256'] = $contentSha256;

        return $self;
    }

    /**
     * Size of `content` in bytes as of this version. `null` when `redacted_at` is set or `operation` is `deleted`. Populated regardless of `view` otherwise.
     */
    public function withContentSizeBytes(?int $contentSizeBytes): self
    {
        $self = clone $this;
        $self['contentSizeBytes'] = $contentSizeBytes;

        return $self;
    }

    /**
     * Who made this change to the memory, or `null` if the author wasn't recorded.
     *
     * Redacting the version doesn't change this field. A `session_actor` here is an agent that wrote through the store's mounted filesystem at `/mnt/memory/`. The version doesn't record the API key that created that session. So the author in `created_by` is who made the change, not who is ultimately responsible for it.
     *
     * You can [retrieve the session](https://platform.claude.com/docs/en/api/beta/sessions/retrieve) to learn more about where the change came from.
     *
     * @param ManagedAgentsActorShape $createdBy
     */
    public function withCreatedBy(
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor $createdBy,
    ): self {
        $self = clone $this;
        $self['createdBy'] = $createdBy;

        return $self;
    }

    /**
     * The memory's path at the time of this write. `null` if and only if `redacted_at` is set.
     */
    public function withPath(?string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * When the version was redacted, in RFC 3339, or `null` if it hasn't been.
     *
     * When set, `content`, `path`, `content_size_bytes`, and `content_sha256` are `null`.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#redact-a-version) to learn more about redaction.
     */
    public function withRedactedAt(?\DateTimeInterface $redactedAt): self
    {
        $self = clone $this;
        $self['redactedAt'] = $redactedAt;

        return $self;
    }

    /**
     * Who redacted this version, or `null` if it has not been redacted. In practice always an `api_actor`, `user_actor`, or `service_account_actor` (agents do not have a redact capability).
     *
     * @param ManagedAgentsActorShape $redactedBy
     */
    public function withRedactedBy(
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor $redactedBy,
    ): self {
        $self = clone $this;
        $self['redactedBy'] = $redactedBy;

        return $self;
    }
}
