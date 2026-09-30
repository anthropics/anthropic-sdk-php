<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Federation\Rules;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Federation\Rules\FederationRuleWorkspace;
use Anthropic\Organization\Federation\Rules\Workspaces\WorkspaceRemoveResponse;
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
     * @param string $federationRuleID ID of the federation rule
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<FederationRuleWorkspace>
     *
     * @throws APIException
     */
    public function list(
        string $federationRuleID,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $federationRuleID ID of the federation rule
     * @param string $workspaceID tagged ID of the workspace to enable this rule for
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $federationRuleID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): FederationRuleWorkspace;

    /**
     * @api
     *
     * @param string $workspaceID ID of the workspace to disable for
     * @param string $federationRuleID ID of the federation rule
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRemoveResponse;
}
