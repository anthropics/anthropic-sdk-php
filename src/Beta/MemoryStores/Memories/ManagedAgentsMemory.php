<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A text document at a path inside a memory store.
 *
 * `content` is `null` when the response uses `view=basic`. `content_size_bytes` and `content_sha256` are always set, so you can detect changes without fetching the content. To retrieve, update, or delete a memory, pass its ID, which stays the same when its path changes.
 *
 * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#view-and-edit-memories) to learn more about working with memories.
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
     * The unique ID of the memory (`mem_...`). It stays the same when the memory's path changes.
     *
     * To retrieve, update, or delete the memory, pass this ID.
     */
    #[Required]
    public string $id;

    /**
     * Lowercase hex SHA-256 digest of the UTF-8 `content` bytes (64 characters). The server applies no normalization, so clients can compute the same hash locally for staleness checks and as the value for a `content_sha256` precondition on update. Always populated, regardless of `view`.
     */
    #[Required('content_sha256')]
    public string $contentSha256;

    /**
     * The size of the memory's `content` in UTF-8 bytes. It is set regardless of `view`.
     */
    #[Required('content_size_bytes')]
    public int $contentSizeBytes;

    /**
     * When this memory was created, in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * ID of the memory store this memory belongs to (a `memstore_...` value).
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /**
     * The ID of the memory version that holds the memory's current content (`memver_...`).
     *
     * Memory versions don't have a flag that marks the latest one. Compare their IDs with this field instead.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#audit-memory-changes) to learn more about memory versions.
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
     * When the memory was last changed, in RFC 3339.
     *
     * To find out who made the change, look at `created_by` on the memory version that `memory_version_id` references.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * The memory's UTF-8 text content, or `null` when the response uses `view=basic`.
     *
     * The maximum size is 100 kB (102,400 bytes).
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
     * (new ManagedAgentsMemory())
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
     * The unique ID of the memory (`mem_...`). It stays the same when the memory's path changes.
     *
     * To retrieve, update, or delete the memory, pass this ID.
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
     * The size of the memory's `content` in UTF-8 bytes. It is set regardless of `view`.
     */
    public function withContentSizeBytes(int $contentSizeBytes): self
    {
        $self = clone $this;
        $self['contentSizeBytes'] = $contentSizeBytes;

        return $self;
    }

    /**
     * When this memory was created, in RFC 3339 format.
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
     * The ID of the memory version that holds the memory's current content (`memver_...`).
     *
     * Memory versions don't have a flag that marks the latest one. Compare their IDs with this field instead.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#audit-memory-changes) to learn more about memory versions.
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
     * When the memory was last changed, in RFC 3339.
     *
     * To find out who made the change, look at `created_by` on the memory version that `memory_version_id` references.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The memory's UTF-8 text content, or `null` when the response uses `view=basic`.
     *
     * The maximum size is 100 kB (102,400 bytes).
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }
}
