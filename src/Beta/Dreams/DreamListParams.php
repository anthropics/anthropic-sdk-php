<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the dreams in the workspace, newest first.
 *
 * Archived dreams are left out unless `include_archived` is `true`.
 *
 * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#list-dreams) for how to page through dreams.
 *
 * @see Anthropic\Services\Beta\DreamsService::list()
 *
 * @phpstan-type DreamListParamsShape = array{
 *   createdAtGt?: \DateTimeInterface|null,
 *   createdAtLt?: \DateTimeInterface|null,
 *   includeArchived?: bool|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   statuses?: list<BetaDreamStatus|value-of<BetaDreamStatus>>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class DreamListParams implements BaseModel
{
    /** @use SdkModel<DreamListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return only dreams created after this time (exclusive), in RFC 3339.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGt;

    /**
     * Return only dreams created before this time (exclusive), in RFC 3339.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLt;

    /**
     * Whether to include archived dreams. Defaults to `false`.
     */
    #[Optional]
    public ?bool $includeArchived;

    /**
     * The maximum number of dreams to return, from 1 to 100. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Return only dreams that have one of these statuses.
     *
     * Repeat the parameter to give more than one status. Leave it out to return dreams of every status.
     *
     * @var list<value-of<BetaDreamStatus>>|null $statuses
     */
    #[Optional(list: BetaDreamStatus::class)]
    public ?array $statuses;

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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaDreamStatus|value-of<BetaDreamStatus>>|null $statuses
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $statuses = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $createdAtGt && $self['createdAtGt'] = $createdAtGt;
        null !== $createdAtLt && $self['createdAtLt'] = $createdAtLt;
        null !== $includeArchived && $self['includeArchived'] = $includeArchived;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $statuses && $self['statuses'] = $statuses;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Return only dreams created after this time (exclusive), in RFC 3339.
     */
    public function withCreatedAtGt(\DateTimeInterface $createdAtGt): self
    {
        $self = clone $this;
        $self['createdAtGt'] = $createdAtGt;

        return $self;
    }

    /**
     * Return only dreams created before this time (exclusive), in RFC 3339.
     */
    public function withCreatedAtLt(\DateTimeInterface $createdAtLt): self
    {
        $self = clone $this;
        $self['createdAtLt'] = $createdAtLt;

        return $self;
    }

    /**
     * Whether to include archived dreams. Defaults to `false`.
     */
    public function withIncludeArchived(bool $includeArchived): self
    {
        $self = clone $this;
        $self['includeArchived'] = $includeArchived;

        return $self;
    }

    /**
     * The maximum number of dreams to return, from 1 to 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Return only dreams that have one of these statuses.
     *
     * Repeat the parameter to give more than one status. Leave it out to return dreams of every status.
     *
     * @param list<BetaDreamStatus|value-of<BetaDreamStatus>> $statuses
     */
    public function withStatuses(array $statuses): self
    {
        $self = clone $this;
        $self['statuses'] = $statuses;

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
