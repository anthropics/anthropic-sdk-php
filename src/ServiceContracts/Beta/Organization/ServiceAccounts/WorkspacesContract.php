<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Beta\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesContract
{
    /**
     * @api
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param int $limit query param: Number of results per page
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function list(
        string $serviceAccountID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param string $workspaceID body param: Tagged workspace ID to add the service account to
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole body param: Role to assign to the service account in this workspace
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $serviceAccountID,
        string $workspaceID,
        NoBillingWorkspaceRole|string $workspaceRole,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember;

    /**
     * @api
     *
     * @param string $workspaceID path param: ID of the workspace
     * @param string $serviceAccountID path param: ID of the service account
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $serviceAccountID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRemoveResponse;
}
