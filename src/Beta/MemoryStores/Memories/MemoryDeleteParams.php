<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Delete a memory.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoriesService::delete()
 *
 * @phpstan-type MemoryDeleteParamsShape = array{
 *   memoryStoreID: string,
 *   expectedContentSha256?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class MemoryDeleteParams implements BaseModel
{
    /** @use SdkModel<MemoryDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The ID of the memory store that holds the memory (`memstore_...`).
     */
    #[Required]
    public string $memoryStoreID;

    /**
     * Delete the memory only if its current `content_sha256` equals this value, given as 64 lowercase hexadecimal characters. Omit it to delete unconditionally.
     *
     * If the hashes differ, the request fails with HTTP status 409 and nothing is deleted.
     */
    #[Optional]
    public ?string $expectedContentSha256;

    /**
     * Optional header to specify the beta version(s) you want to use.
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
     * `new MemoryDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemoryDeleteParams::with(memoryStoreID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemoryDeleteParams)->withMemoryStoreID(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $memoryStoreID,
        ?string $expectedContentSha256 = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;

        null !== $expectedContentSha256 && $self['expectedContentSha256'] = $expectedContentSha256;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The ID of the memory store that holds the memory (`memstore_...`).
     */
    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * Delete the memory only if its current `content_sha256` equals this value, given as 64 lowercase hexadecimal characters. Omit it to delete unconditionally.
     *
     * If the hashes differ, the request fails with HTTP status 409 and nothing is deleted.
     */
    public function withExpectedContentSha256(
        string $expectedContentSha256
    ): self {
        $self = clone $this;
        $self['expectedContentSha256'] = $expectedContentSha256;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
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
