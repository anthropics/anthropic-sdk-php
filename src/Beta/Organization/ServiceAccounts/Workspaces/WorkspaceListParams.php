<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts\Workspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * List the workspaces a service account is a member of.
 *
 * Each entry includes the service account's `workspace_role` in that
 * workspace. Use `limit` and the `next_page` cursor to paginate. When the
 * service account has no explicit default-workspace membership, the
 * implicit (`implicit: true`) membership is returned as the first entry on
 * the first page; with `limit=1` the first page may return up to 2 entries
 * (the implicit entry plus one explicit membership) so a pagination cursor
 * can be derived. Memberships are returned only while
 * the service account is active. Without a `page` cursor, an archived
 * service account returns an empty list. A `page` cursor that does not
 * match an active membership returns a 400 invalid-request error. A cursor
 * stops matching when the membership is removed, the workspace is deleted,
 * or the service account is archived. Restart pagination from the first
 * page to recover.
 *
 * @see Anthropic\Services\Beta\Organization\ServiceAccounts\WorkspacesService::list()
 *
 * @phpstan-type WorkspaceListParamsShape = array{
 *   limit?: int|null,
 *   page?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WorkspaceListParams implements BaseModel
{
    /** @use SdkModel<WorkspaceListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of results per page.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Number of results per page.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

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
}
