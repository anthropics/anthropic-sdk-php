<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Memory Versions.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoryVersionsService::list()
 *
 * @phpstan-type MemoryVersionListParamsShape = array{
 *   apiKeyID?: string|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   limit?: int|null,
 *   memoryID?: string|null,
 *   operation?: null|ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation>,
 *   page?: string|null,
 *   serviceAccountID?: string|null,
 *   sessionID?: string|null,
 *   view?: null|ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class MemoryVersionListParams implements BaseModel
{
    /** @use SdkModel<MemoryVersionListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return only versions written with the API key that has this ID.
     */
    #[Optional]
    public ?string $apiKeyID;

    /**
     * Return versions created at or after this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return versions created at or before this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * The maximum number of versions to return per page, from 1 to 100. Defaults to 20.
     *
     * With `view=full`, a page holds at most 20 versions.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Return only versions of the memory with this ID (`mem_...`).
     *
     * The filter still works after the memory is deleted. While that memory's versions are retained, the results include the version whose `operation` is `deleted`.
     */
    #[Optional]
    public ?string $memoryID;

    /**
     * Return only versions that record this kind of change.
     *
     * @var value-of<ManagedAgentsMemoryVersionOperation>|null $operation
     */
    #[Optional(enum: ManagedAgentsMemoryVersionOperation::class)]
    public ?string $operation;

    /**
     * The `next_page` value from a previous response, to get the next page. Omit it to get the first page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Return only versions written by the service account with this ID (`svac_...`).
     */
    #[Optional]
    public ?string $serviceAccountID;

    /**
     * Return only versions written by the session with this ID.
     */
    #[Optional]
    public ?string $sessionID;

    /**
     * Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
     *
     * With `full`, list operations return at most 20 items per page.
     *
     * @var value-of<ManagedAgentsMemoryView>|null $view
     */
    #[Optional(enum: ManagedAgentsMemoryView::class)]
    public ?string $view;

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
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation>|null $operation
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>|null $view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $apiKeyID = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ?string $memoryID = null,
        ManagedAgentsMemoryVersionOperation|string|null $operation = null,
        ?string $page = null,
        ?string $serviceAccountID = null,
        ?string $sessionID = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $apiKeyID && $self['apiKeyID'] = $apiKeyID;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $limit && $self['limit'] = $limit;
        null !== $memoryID && $self['memoryID'] = $memoryID;
        null !== $operation && $self['operation'] = $operation;
        null !== $page && $self['page'] = $page;
        null !== $serviceAccountID && $self['serviceAccountID'] = $serviceAccountID;
        null !== $sessionID && $self['sessionID'] = $sessionID;
        null !== $view && $self['view'] = $view;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Return only versions written with the API key that has this ID.
     */
    public function withAPIKeyID(string $apiKeyID): self
    {
        $self = clone $this;
        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * Return versions created at or after this time (inclusive).
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return versions created at or before this time (inclusive).
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * The maximum number of versions to return per page, from 1 to 100. Defaults to 20.
     *
     * With `view=full`, a page holds at most 20 versions.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Return only versions of the memory with this ID (`mem_...`).
     *
     * The filter still works after the memory is deleted. While that memory's versions are retained, the results include the version whose `operation` is `deleted`.
     */
    public function withMemoryID(string $memoryID): self
    {
        $self = clone $this;
        $self['memoryID'] = $memoryID;

        return $self;
    }

    /**
     * Return only versions that record this kind of change.
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
     * The `next_page` value from a previous response, to get the next page. Omit it to get the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Return only versions written by the service account with this ID (`svac_...`).
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * Return only versions written by the session with this ID.
     */
    public function withSessionID(string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
     *
     * With `full`, list operations return at most 20 items per page.
     *
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view
     */
    public function withView(ManagedAgentsMemoryView|string $view): self
    {
        $self = clone $this;
        $self['view'] = $view;

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
