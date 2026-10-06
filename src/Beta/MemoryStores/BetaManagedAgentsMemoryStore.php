<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores;

use Anthropic\Beta\MemoryStores\BetaManagedAgentsMemoryStore\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A `memory_store`: a named container for agent memories, scoped to a workspace. Attach a store to a session via `resources[]` to mount it as a directory the agent can read and write.
 *
 * @phpstan-type BetaManagedAgentsMemoryStoreShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   description: string,
 *   metadata: array<string,string>,
 *   name: string,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaManagedAgentsMemoryStore implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMemoryStoreShape> */
    use SdkModel;

    /**
     * Unique identifier for the memory store (a `memstore_...` tagged ID). Use this when attaching the store to a session, or in the `{memory_store_id}` path parameter of subsequent calls.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp when the store was archived, or `null` if active. Set once and never cleared; archiving is one-way. Archived stores are read-only and cannot be attached to new sessions.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * Timestamp when the store was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Free-text description of what the store contains, up to 1024 characters. Included in the agent's system prompt when the store is attached, so word it to be useful to the agent. Empty string when unset.
     */
    #[Required]
    public string $description;

    /**
     * Arbitrary key-value tags for your own bookkeeping (such as the end user a store belongs to). Up to 16 pairs; keys 1–64 characters; values up to 512 characters. Returned on retrieve/list but not filterable.
     *
     * @var array<string,string> $metadata
     */
    #[Required(map: 'string')]
    public array $metadata;

    /**
     * Human-readable name for the store. 1–255 characters. The store's mount-path slug under `/mnt/memory/` is derived from this name.
     */
    #[Required]
    public string $name;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Timestamp when the store's `name`, `description`, or `metadata` was last modified. Memory writes inside the store do not advance this.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new BetaManagedAgentsMemoryStore()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMemoryStore::with(
     *   id: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   description: ...,
     *   metadata: ...,
     *   name: ...,
     *   type: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMemoryStore())
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withMetadata(...)
     *   ->withName(...)
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
     * @param array<string,string> $metadata
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        string $description,
        array $metadata,
        string $name,
        Type|string $type,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['metadata'] = $metadata;
        $self['name'] = $name;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Unique identifier for the memory store (a `memstore_...` tagged ID). Use this when attaching the store to a session, or in the `{memory_store_id}` path parameter of subsequent calls.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Timestamp when the store was archived, or `null` if active. Set once and never cleared; archiving is one-way. Archived stores are read-only and cannot be attached to new sessions.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * Timestamp when the store was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Free-text description of what the store contains, up to 1024 characters. Included in the agent's system prompt when the store is attached, so word it to be useful to the agent. Empty string when unset.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Arbitrary key-value tags for your own bookkeeping (such as the end user a store belongs to). Up to 16 pairs; keys 1–64 characters; values up to 512 characters. Returned on retrieve/list but not filterable.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Human-readable name for the store. 1–255 characters. The store's mount-path slug under `/mnt/memory/` is derived from this name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
     * Timestamp when the store's `name`, `description`, or `metadata` was last modified. Memory writes inside the store do not advance this.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
