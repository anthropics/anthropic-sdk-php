<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

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
 *   type: 'memory_store',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaManagedAgentsMemoryStore implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMemoryStoreShape> */
    use SdkModel;

    /** @var 'memory_store' $type */
    #[Required(type: new ConstantOf('memory_store'))]
    public string $type = 'memory_store';

    /**
     * The unique ID of the memory store (`memstore_...`). Use it to attach the store to a session.
     */
    #[Required]
    public string $id;

    /**
     * When the memory store was archived, in RFC 3339, or `null` if it hasn't been.
     *
     * Archiving can't be undone. An archived store can't be attached to new sessions. You can't create or update its memories or update the store. You can still read and delete its memories, redact their versions, and delete the store.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#archive-a-store) to learn more about archiving.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * When the memory store was created, in RFC 3339.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Free-text description of what the store contains, up to 1,024 characters. Included in the agent's system prompt when the store is attached, so word it to be useful to the agent. Empty string when unset.
     */
    #[Required]
    public string $description;

    /**
     * Key-value pairs for your own use, such as the end user that the store belongs to.
     *
     * A store has at most 16 pairs. Keys are 1 to 64 characters long and values at most 512 characters. You can't filter lists by metadata.
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

    /**
     * When the memory store was last changed, in RFC 3339.
     *
     * Changing its `name`, `description`, or `metadata` updates it. Archiving the store does too. Changes to the store's memories don't.
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
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        string $description,
        array $metadata,
        string $name,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['metadata'] = $metadata;
        $self['name'] = $name;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The unique ID of the memory store (`memstore_...`). Use it to attach the store to a session.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the memory store was archived, in RFC 3339, or `null` if it hasn't been.
     *
     * Archiving can't be undone. An archived store can't be attached to new sessions. You can't create or update its memories or update the store. You can still read and delete its memories, redact their versions, and delete the store.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#archive-a-store) to learn more about archiving.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * When the memory store was created, in RFC 3339.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Free-text description of what the store contains, up to 1,024 characters. Included in the agent's system prompt when the store is attached, so word it to be useful to the agent. Empty string when unset.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Key-value pairs for your own use, such as the end user that the store belongs to.
     *
     * A store has at most 16 pairs. Keys are 1 to 64 characters long and values at most 512 characters. You can't filter lists by metadata.
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
     * @param 'memory_store' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When the memory store was last changed, in RFC 3339.
     *
     * Changing its `name`, `description`, or `metadata` updates it. Archiving the store does too. Changes to the store's memories don't.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
