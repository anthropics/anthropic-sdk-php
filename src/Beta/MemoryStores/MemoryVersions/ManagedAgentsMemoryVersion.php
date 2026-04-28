<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A `memory_version` object: one immutable, attributed row in a memory's append-only history. Every non-no-op mutation to a memory produces a new version. Versions belong to the store (not the individual memory) and persist after the memory is deleted. Retrieving a redacted version returns 200 with `content`, `path`, `content_size_bytes`, and `content_sha256` set to `null`; branch on `redacted_at`, not HTTP status.
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
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * ID of the memory this version snapshots (a `mem_...` value). Remains valid after the memory is deleted; pass it as `memory_id` to [List memory versions](/en/api/beta/memory_stores/memory_versions/list) to retrieve the full lineage including the `deleted` row.
     */
    #[Required('memory_id')]
    public string $memoryID;

    /**
     * ID of the memory store this version belongs to (a `memstore_...` value).
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * The kind of mutation a `memory_version` records. Every non-no-op mutation to a memory appends exactly one version row with one of these values.
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
     * Identifies who performed a write or redact operation. Captured at write time on the `memory_version` row. The API key that created a session is not recorded on agent writes; attribution answers who made the write, not who is ultimately responsible. Look up session provenance separately via the [Sessions API](/en/api/sessions-retrieve).
     *
     * @var ManagedAgentsActorVariants|null $createdBy
     */
    #[Optional('created_by', union: ManagedAgentsActor::class)]
    public ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|null $createdBy;

    /**
     * The memory's path at the time of this write. `null` if and only if `redacted_at` is set.
     */
    #[Optional(nullable: true)]
    public ?string $path;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('redacted_at', nullable: true)]
    public ?\DateTimeInterface $redactedAt;

    /**
     * Identifies who performed a write or redact operation. Captured at write time on the `memory_version` row. The API key that created a session is not recorded on agent writes; attribution answers who made the write, not who is ultimately responsible. Look up session provenance separately via the [Sessions API](/en/api/sessions-retrieve).
     *
     * @var ManagedAgentsActorVariants|null $redactedBy
     */
    #[Optional('redacted_by', union: ManagedAgentsActor::class)]
    public ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|null $redactedBy;

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
     * (new ManagedAgentsMemoryVersion)
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
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor|null $createdBy = null,
        ?string $path = null,
        ?\DateTimeInterface $redactedAt = null,
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor|null $redactedBy = null,
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
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * ID of the memory this version snapshots (a `mem_...` value). Remains valid after the memory is deleted; pass it as `memory_id` to [List memory versions](/en/api/beta/memory_stores/memory_versions/list) to retrieve the full lineage including the `deleted` row.
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
     * The kind of mutation a `memory_version` records. Every non-no-op mutation to a memory appends exactly one version row with one of these values.
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
     * Identifies who performed a write or redact operation. Captured at write time on the `memory_version` row. The API key that created a session is not recorded on agent writes; attribution answers who made the write, not who is ultimately responsible. Look up session provenance separately via the [Sessions API](/en/api/sessions-retrieve).
     *
     * @param ManagedAgentsActorShape $createdBy
     */
    public function withCreatedBy(
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor $createdBy,
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
     * A timestamp in RFC 3339 format.
     */
    public function withRedactedAt(?\DateTimeInterface $redactedAt): self
    {
        $self = clone $this;
        $self['redactedAt'] = $redactedAt;

        return $self;
    }

    /**
     * Identifies who performed a write or redact operation. Captured at write time on the `memory_version` row. The API key that created a session is not recorded on agent writes; attribution answers who made the write, not who is ultimately responsible. Look up session provenance separately via the [Sessions API](/en/api/sessions-retrieve).
     *
     * @param ManagedAgentsActorShape $redactedBy
     */
    public function withRedactedBy(
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor $redactedBy,
    ): self {
        $self = clone $this;
        $self['redactedBy'] = $redactedBy;

        return $self;
    }
}
