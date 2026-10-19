<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create a Memory Store.
 *
 * @see Anthropic\Services\Beta\MemoryStoresService::create()
 *
 * @phpstan-type MemoryStoreCreateParamsShape = array{
 *   name: string,
 *   description?: string|null,
 *   metadata?: array<string,string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class MemoryStoreCreateParams implements BaseModel
{
    /** @use SdkModel<MemoryStoreCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The name of the memory store, 1 to 255 characters long, without control characters. Names don't have to be unique in a workspace.
     *
     * In a session, the store's directory under `/mnt/memory/` is based on this name. The name is lowercased and every run of characters other than ASCII letters and digits becomes one hyphen. The session's memory store resource gives the exact path in `mount_path`.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#how-the-agent-accesses-memory) to learn more about how agents access memory stores.
     */
    #[Required]
    public string $name;

    /**
     * Free-text description of what the store contains, up to 1,024 characters. Included in the agent's system prompt when the store is attached, so word it to be useful to the agent.
     */
    #[Optional]
    public ?string $description;

    /**
     * Key-value pairs for your own use, such as the end user that the store belongs to. The agent doesn't see them.
     *
     * A store has at most 16 pairs. Keys are 1 to 64 characters long and values at most 512 characters.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

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

    /**
     * `new MemoryStoreCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemoryStoreCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemoryStoreCreateParams())->withName(...)
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
     * @param array<string,string>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $name,
        ?string $description = null,
        ?array $metadata = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The name of the memory store, 1 to 255 characters long, without control characters. Names don't have to be unique in a workspace.
     *
     * In a session, the store's directory under `/mnt/memory/` is based on this name. The name is lowercased and every run of characters other than ASCII letters and digits becomes one hyphen. The session's memory store resource gives the exact path in `mount_path`.
     *
     * See the [memory guide](https://platform.claude.com/docs/en/managed-agents/memory#how-the-agent-accesses-memory) to learn more about how agents access memory stores.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Free-text description of what the store contains, up to 1,024 characters. Included in the agent's system prompt when the store is attached, so word it to be useful to the agent.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Key-value pairs for your own use, such as the end user that the store belongs to. The agent doesn't see them.
     *
     * A store has at most 16 pairs. Keys are 1 to 64 characters long and values at most 512 characters.
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
