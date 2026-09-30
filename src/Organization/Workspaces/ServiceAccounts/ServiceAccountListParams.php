<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\ServiceAccounts;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * List the service accounts that are members of a workspace.
 *
 * Each entry includes the service account's `workspace_role`. Use `limit`
 * and the `next_page` cursor to paginate. Archived workspaces return 400;
 * use `GET /service_accounts/{id}/workspaces` to audit memberships of an
 * archived workspace. The implicit default-workspace membership is not
 * included in this list. Memberships of archived service accounts are
 * omitted from the results.
 *
 * @see Anthropic\Services\Organization\Workspaces\ServiceAccountsService::list()
 *
 * @phpstan-type ServiceAccountListParamsShape = array{
 *   limit?: int|null, page?: string|null
 * }
 */
final class ServiceAccountListParams implements BaseModel
{
    /** @use SdkModel<ServiceAccountListParamsShape> */
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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $limit = null, ?string $page = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;

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
}
