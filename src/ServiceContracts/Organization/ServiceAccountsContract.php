<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ServiceAccounts\ServiceAccount;
use Anthropic\Organization\ServiceAccounts\ServiceAccountCreateParams\OrganizationRole;
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
     * @param string $name Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param string|null $description optional free-text description
     * @param OrganizationRole|value-of<OrganizationRole> $organizationRole Org-level role. Defaults to `developer`.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $description = null,
        OrganizationRole|string|null $organizationRole = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccount;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        RequestOptions|array|null $requestOptions = null
    ): ServiceAccount;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account to update
     * @param string|null $description Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     * @param \Anthropic\Organization\ServiceAccounts\ServiceAccountUpdateParams\OrganizationRole|value-of<\Anthropic\Organization\ServiceAccounts\ServiceAccountUpdateParams\OrganizationRole>|null $organizationRole Replaces the org-level role. Omit or send `null` to leave unchanged.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $serviceAccountID,
        ?string $description = null,
        \Anthropic\Organization\ServiceAccounts\ServiceAccountUpdateParams\OrganizationRole|string|null $organizationRole = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccount;

    /**
     * @api
     *
     * @param bool $includeArchived Include archived resources. Defaults to false.
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
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
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account to archive
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $serviceAccountID,
        RequestOptions|array|null $requestOptions = null
    ): ServiceAccount;
}
