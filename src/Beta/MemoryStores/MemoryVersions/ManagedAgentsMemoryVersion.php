<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
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

    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    #[Required('memory_id')]
    public string $memoryID;

    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * MemoryVersionOperation enum.
     *
     * @var value-of<ManagedAgentsMemoryVersionOperation> $operation
     */
    #[Required(enum: ManagedAgentsMemoryVersionOperation::class)]
    public string $operation;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    #[Optional(nullable: true)]
    public ?string $content;

    #[Optional('content_sha256', nullable: true)]
    public ?string $contentSha256;

    #[Optional('content_size_bytes', nullable: true)]
    public ?int $contentSizeBytes;

    /** @var ManagedAgentsActorVariants|null $createdBy */
    #[Optional('created_by', union: ManagedAgentsActor::class)]
    public ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|null $createdBy;

    #[Optional(nullable: true)]
    public ?string $path;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('redacted_at', nullable: true)]
    public ?\DateTimeInterface $redactedAt;

    /** @var ManagedAgentsActorVariants|null $redactedBy */
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

    public function withMemoryID(string $memoryID): self
    {
        $self = clone $this;
        $self['memoryID'] = $memoryID;

        return $self;
    }

    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * MemoryVersionOperation enum.
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

    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withContentSha256(?string $contentSha256): self
    {
        $self = clone $this;
        $self['contentSha256'] = $contentSha256;

        return $self;
    }

    public function withContentSizeBytes(?int $contentSizeBytes): self
    {
        $self = clone $this;
        $self['contentSizeBytes'] = $contentSizeBytes;

        return $self;
    }

    /**
     * @param ManagedAgentsActorShape $createdBy
     */
    public function withCreatedBy(
        ManagedAgentsSessionActor|array|ManagedAgentsAPIActor|ManagedAgentsUserActor $createdBy,
    ): self {
        $self = clone $this;
        $self['createdBy'] = $createdBy;

        return $self;
    }

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
