<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccount;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountCreateParams\OrganizationRole;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ServiceAccountsContract
{
    /**
     * @api
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
    ): ServiceAccount;

    /**
     * @api
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
    ): ServiceAccount;

    /**
     * @api
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
    ): ServiceAccount;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): ServiceAccount;
}
