<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Federation\Rules;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleWorkspace;
use Anthropic\Beta\Organization\Federation\Rules\Workspaces\WorkspaceRemoveResponse;
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
     * @param string $federationRuleID path param: ID of the federation rule
     * @param int $limit query param: Number of results per page
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaFederationRuleWorkspace>
     *
     * @throws APIException
     */
    public function list(
        string $federationRuleID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $federationRuleID path param: ID of the federation rule
     * @param string $workspaceID body param: Tagged ID of the workspace to enable this rule for
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $federationRuleID,
        string $workspaceID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationRuleWorkspace;

    /**
     * @api
     *
     * @param string $workspaceID path param: ID of the workspace to disable for
     * @param string $federationRuleID path param: ID of the federation rule
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $federationRuleID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRemoveResponse;
}
