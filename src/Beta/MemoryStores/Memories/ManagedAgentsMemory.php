<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A `memory` object: a single text document at a hierarchical path inside a memory store. The `content` field is populated when `view=full` and `null` when `view=basic`; the `content_size_bytes` and `content_sha256` fields are always populated so sync clients can diff without fetching content. Memories are addressed by their `mem_...` ID; the path is the create key and can be changed via update.
 *
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

    /**
     * Unique identifier for this memory (a `mem_...` value). Stable across renames; use this ID, not the path, to read, update, or delete the memory.
     */
    #[Required]
    public string $id;

    /**
     * Lowercase hex SHA-256 digest of the UTF-8 `content` bytes (64 characters). The server applies no normalization, so clients can compute the same hash locally for staleness checks and as the value for a `content_sha256` precondition on update. Always populated, regardless of `view`.
     */
    #[Required('content_sha256')]
    public string $contentSha256;

    /**
     * Size of `content` in bytes (the UTF-8 plaintext length). Always populated, regardless of `view`.
     */
    #[Required('content_size_bytes')]
    public int $contentSizeBytes;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * ID of the memory store this memory belongs to (a `memstore_...` value).
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * ID of the `memory_version` representing this memory's current content (a `memver_...` value). This is the authoritative head pointer; `memory_version` objects do not carry an `is_latest` flag, so compare against this field instead. Enumerate the full history via [List memory versions](/en/api/beta/memory_stores/memory_versions/list).
     */
    #[Required('memory_version_id')]
    public string $memoryVersionID;

    /**
     * Hierarchical path of the memory within the store, e.g. `/projects/foo/notes.md`. Always starts with `/`. Paths are case-sensitive and unique within a store. Maximum 1,024 bytes.
     */
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

    /**
     * The memory's UTF-8 text content. Populated when `view=full`; `null` when `view=basic`. Maximum 100 kB (102,400 bytes).
     */
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

    /**
     * Unique identifier for this memory (a `mem_...` value). Stable across renames; use this ID, not the path, to read, update, or delete the memory.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Lowercase hex SHA-256 digest of the UTF-8 `content` bytes (64 characters). The server applies no normalization, so clients can compute the same hash locally for staleness checks and as the value for a `content_sha256` precondition on update. Always populated, regardless of `view`.
     */
    public function withContentSha256(string $contentSha256): self
    {
        $self = clone $this;
        $self['contentSha256'] = $contentSha256;

        return $self;
    }

    /**
     * Size of `content` in bytes (the UTF-8 plaintext length). Always populated, regardless of `view`.
     */
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

    /**
     * ID of the memory store this memory belongs to (a `memstore_...` value).
     */
    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * ID of the `memory_version` representing this memory's current content (a `memver_...` value). This is the authoritative head pointer; `memory_version` objects do not carry an `is_latest` flag, so compare against this field instead. Enumerate the full history via [List memory versions](/en/api/beta/memory_stores/memory_versions/list).
     */
    public function withMemoryVersionID(string $memoryVersionID): self
    {
        $self = clone $this;
        $self['memoryVersionID'] = $memoryVersionID;

        return $self;
    }

    /**
     * Hierarchical path of the memory within the store, e.g. `/projects/foo/notes.md`. Always starts with `/`. Paths are case-sensitive and unique within a store. Maximum 1,024 bytes.
     */
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

    /**
     * The memory's UTF-8 text content. Populated when `view=full`; `null` when `view=basic`. Maximum 100 kB (102,400 bytes).
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }
}
