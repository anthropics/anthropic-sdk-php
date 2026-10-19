<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update a Memory Store.
 *
 * @see Anthropic\Services\Beta\MemoryStoresService::update()
 *
 * @phpstan-type MemoryStoreUpdateParamsShape = array{
 *   description?: string|null,
 *   metadata?: array<string,string|null>|null,
 *   name?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class MemoryStoreUpdateParams implements BaseModel
{
    /** @use SdkModel<MemoryStoreUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * New description for the store, up to 1,024 characters. Pass an empty string to clear it.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Changes to apply to the memory store's metadata. Keys you leave out keep their values.
     *
     * Set a key to a string to add or replace it, or to `null` to remove it. After the change, the metadata can hold at most 16 key-value pairs. Keys are 1 to 64 characters long and values at most 512 characters.
     *
     * @var array<string,string|null>|null $metadata
     */
    #[Optional(type: new MapOf('string', nullable: true), nullable: true)]
    public ?array $metadata;

    /**
     * The new name of the memory store, 1 to 255 characters long, without control characters.
     *
     * Sessions created after the change use the new name for the store's directory under `/mnt/memory/`.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string|null>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $description = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * New description for the store, up to 1,024 characters. Pass an empty string to clear it.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Changes to apply to the memory store's metadata. Keys you leave out keep their values.
     *
     * Set a key to a string to add or replace it, or to `null` to remove it. After the change, the metadata can hold at most 16 key-value pairs. Keys are 1 to 64 characters long and values at most 512 characters.
     *
     * @param array<string,string|null>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * The new name of the memory store, 1 to 255 characters long, without control characters.
     *
     * Sessions created after the change use the new name for the store's directory under `/mnt/memory/`.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
