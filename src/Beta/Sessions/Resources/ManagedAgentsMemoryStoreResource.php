<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource\Access;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A memory store attached to an agent session.
 *
 * @phpstan-type ManagedAgentsMemoryStoreResourceShape = array{
 *   memoryStoreID: string,
 *   type: Type|value-of<Type>,
 *   access?: null|Access|value-of<Access>,
 *   description?: string|null,
 *   instructions?: string|null,
 *   mountPath?: string|null,
 *   name?: string|null,
 * }
 */
final class ManagedAgentsMemoryStoreResource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMemoryStoreResourceShape> */
    use SdkModel;

    /**
     * The memory store ID (memstore_...). Must belong to the caller's organization and workspace.
     */
    #[Required('memory_store_id')]
    public string $memoryStoreID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Access mode for an attached memory store.
     *
     * @var value-of<Access>|null $access
     */
    #[Optional(enum: Access::class, nullable: true)]
    public ?string $access;

    /**
     * Description of the memory store, snapshotted at attach time. Rendered into the agent's system prompt. Empty string when the store has no description.
     */
    #[Optional]
    public ?string $description;

    /**
     * Per-attachment guidance for the agent on how to use this store. Rendered into the memory section of the system prompt. Max 4096 chars.
     */
    #[Optional(nullable: true)]
    public ?string $instructions;

    /**
     * Filesystem path where the store is mounted in the session container, e.g. /mnt/memory/user-preferences. Derived from the store's name. Output-only.
     */
    #[Optional('mount_path', nullable: true)]
    public ?string $mountPath;

    /**
     * Display name of the memory store, snapshotted at attach time. Later edits to the store's name do not propagate to this resource.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * `new ManagedAgentsMemoryStoreResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMemoryStoreResource::with(memoryStoreID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMemoryStoreResource)->withMemoryStoreID(...)->withType(...)
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
     * @param Access|value-of<Access>|null $access
     */
    public static function with(
        string $memoryStoreID,
        Type|string $type,
        Access|string|null $access = null,
        ?string $description = null,
        ?string $instructions = null,
        ?string $mountPath = null,
        ?string $name = null,
    ): self {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;
        $self['type'] = $type;

        null !== $access && $self['access'] = $access;
        null !== $description && $self['description'] = $description;
        null !== $instructions && $self['instructions'] = $instructions;
        null !== $mountPath && $self['mountPath'] = $mountPath;
        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * The memory store ID (memstore_...). Must belong to the caller's organization and workspace.
     */
    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

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
     * Access mode for an attached memory store.
     *
     * @param Access|value-of<Access>|null $access
     */
    public function withAccess(Access|string|null $access): self
    {
        $self = clone $this;
        $self['access'] = $access;

        return $self;
    }

    /**
     * Description of the memory store, snapshotted at attach time. Rendered into the agent's system prompt. Empty string when the store has no description.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Per-attachment guidance for the agent on how to use this store. Rendered into the memory section of the system prompt. Max 4096 chars.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * Filesystem path where the store is mounted in the session container, e.g. /mnt/memory/user-preferences. Derived from the store's name. Output-only.
     */
    public function withMountPath(?string $mountPath): self
    {
        $self = clone $this;
        $self['mountPath'] = $mountPath;

        return $self;
    }

    /**
     * Display name of the memory store, snapshotted at attach time. Later edits to the store's name do not propagate to this resource.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
