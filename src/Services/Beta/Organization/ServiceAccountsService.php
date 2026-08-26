<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccount;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountCreateParams\OrganizationRole;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ServiceAccountsContract;
use Anthropic\Services\Beta\Organization\ServiceAccounts\WorkspacesService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ServiceAccountsService implements ServiceAccountsContract
{
    /**
     * @api
     */
    public ServiceAccountsRawService $raw;

    /**
     * @api
     */
    public WorkspacesService $workspaces;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ServiceAccountsRawService($client);
        $this->workspaces = new WorkspacesService($client);
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Create a service account.
     *
     * A service account is a named workload identity that federation rules
     * target. `organization_role` is `developer` (default) or `admin`; a rule
     * may only be created or retargeted to grant `org:admin` scope when the
     * target's `organization_role` is `admin`. Creating an `admin`-role service
     * account requires an interactive credential (a user OAuth token or a
     * Console session) — a workload may only create `developer`-role service
     * accounts.
     *
     * @param string $name Body param: Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param string|null $description body param: Optional free-text description
     * @param OrganizationRole|value-of<OrganizationRole> $organizationRole Body param: Org-level role. Defaults to `developer`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $description = null,
        OrganizationRole|string|null $organizationRole = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccount {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'description' => $description,
                'organizationRole' => $organizationRole,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Retrieve a service account by its ID (`svac_...`).
     *
     * @param string $serviceAccountID ID of the service account
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccount {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Update a service account.
     *
     * Only `description` and `organization_role` are mutable; `name` cannot be
     * changed. Archived service accounts cannot be updated; this returns 400.
     * Setting `organization_role` to `admin` (even when unchanged) requires an
     * interactive credential (a user OAuth token or a Console session).
     *
     * @param string $serviceAccountID path param: ID of the service account to update
     * @param string|null $description Body param: Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     * @param \Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountUpdateParams\OrganizationRole|value-of<\Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountUpdateParams\OrganizationRole>|null $organizationRole Body param: Replaces the org-level role. Omit or send `null` to leave unchanged.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $serviceAccountID,
        ?string $description = null,
        \Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountUpdateParams\OrganizationRole|string|null $organizationRole = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccount {
        $params = Util::removeNulls(
            [
                'description' => $description,
                'organizationRole' => $organizationRole,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * List service accounts in the caller's organization.
     *
     * Results are ordered by creation time, newest first. Use `limit` and the
     * `next_page` cursor to paginate; set `include_archived=true` to include
     * archived service accounts.
     *
     * @param bool $includeArchived Query param: Include archived resources. Defaults to false.
     * @param int $limit query param: Number of results per page
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ServiceAccount>
     *
     * @throws APIException
     */
    public function list(
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Archive a service account.
     *
     * Idempotent; re-archiving returns the service account with its original
     * `archived_at`. Rejected with 400 if any live (non-archived) federation
     * rule still targets this service account, same as issuer archival; archive
     * those rules first or change their target to another service account.
     *
     * @param string $serviceAccountID ID of the service account to archive
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $serviceAccountID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccount {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
