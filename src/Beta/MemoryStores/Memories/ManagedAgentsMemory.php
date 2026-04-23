<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ManagedAgentsMemoryShape = array{
 *   id: string,
 *   contentSha256: string,
 *   contentSizeBytes: int,
 *   createdAt: \DateTimeInterface,
 *   memoryStoreID: string,
 *   memoryVersionID: string,
 *   path: string,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   content?: string|null,
 * }
 */
final class ManagedAgentsMemory implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMemoryShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required('content_sha256')]
    public string $contentSha256;

    #[Required('content_size_bytes')]
    public int $contentSizeBytes;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    #[Required('memory_store_id')]
    public string $memoryStoreID;

    #[Required('memory_version_id')]
    public string $memoryVersionID;

    #[Required]
    public string $path;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    #[Optional(nullable: true)]
    public ?string $content;

    /**
     * `new ManagedAgentsMemory()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMemory::with(
     *   id: ...,
     *   contentSha256: ...,
     *   contentSizeBytes: ...,
     *   createdAt: ...,
     *   memoryStoreID: ...,
     *   memoryVersionID: ...,
     *   path: ...,
     *   type: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMemory)
     *   ->withID(...)
     *   ->withContentSha256(...)
     *   ->withContentSizeBytes(...)
     *   ->withCreatedAt(...)
     *   ->withMemoryStoreID(...)
     *   ->withMemoryVersionID(...)
     *   ->withPath(...)
     *   ->withType(...)
     *   ->withUpdatedAt(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        string $contentSha256,
        int $contentSizeBytes,
        \DateTimeInterface $createdAt,
        string $memoryStoreID,
        string $memoryVersionID,
        string $path,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        ?string $content = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['contentSha256'] = $contentSha256;
        $self['contentSizeBytes'] = $contentSizeBytes;
        $self['createdAt'] = $createdAt;
        $self['memoryStoreID'] = $memoryStoreID;
        $self['memoryVersionID'] = $memoryVersionID;
        $self['path'] = $path;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;

        null !== $content && $self['content'] = $content;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withContentSha256(string $contentSha256): self
    {
        $self = clone $this;
        $self['contentSha256'] = $contentSha256;

        return $self;
    }

    public function withContentSizeBytes(int $contentSizeBytes): self
    {
        $self = clone $this;
        $self['contentSizeBytes'] = $contentSizeBytes;

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

    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    public function withMemoryVersionID(string $memoryVersionID): self
    {
        $self = clone $this;
        $self['memoryVersionID'] = $memoryVersionID;

        return $self;
    }

    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

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

    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }
}
