<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\OwnerType;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\Source;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceRetrieveParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceUpdateParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceUpdateParams\DefaultInstallationPreference;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidateArchiveParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidateRepositoryParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationReport;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\PluginMarketplacesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class PluginMarketplacesRawService implements PluginMarketplacesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve a plugin marketplace by ID.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $marketplaceID path param: ID of the plugin marketplace (prefixed `marketplace_`)
     * @param array{
     *   organizationID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginMarketplaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplace>
     *
     * @throws APIException
     */
    public function retrieve(
        string $marketplaceID,
        array|PluginMarketplaceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginMarketplaceRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['organizationID']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/plugin_marketplaces/%1$s?beta=true', $marketplaceID,
            ],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['organizationID' => 'organization_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: PluginMarketplace::class,
        );
    }

    /**
     * @api
     *
     * Set the default installation setting of one of the organization's own plugin
     * marketplaces. Every Plugin in it without a setting of its own gets this default as
     * its organization-wide setting, including Plugins added later.
     *
     * Pass it as `default_installation_preference`. A member's personal marketplace
     * cannot be updated here (403).
     *
     * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $marketplaceID path param: ID of the plugin marketplace (prefixed `marketplace_`)
     * @param array{
     *   defaultInstallationPreference: DefaultInstallationPreference|value-of<DefaultInstallationPreference>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginMarketplaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplace>
     *
     * @throws APIException
     */
    public function update(
        string $marketplaceID,
        array|PluginMarketplaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginMarketplaceUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/plugin_marketplaces/%1$s?beta=true', $marketplaceID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: PluginMarketplace::class,
        );
    }

    /**
     * @api
     *
     * List the plugin marketplaces Plugins live in, newest first: the organization's own
     * and its members' personal ones.
     *
     * Plugin marketplaces are created, connected to a repository and deleted in
     * claude.ai, not through this API. The organization's library marketplace, the
     * organization-owned `manual` marketplace that uploads go to when no marketplace is
     * named, is created the first time something is put in it and is listed from then on.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param array{
     *   limit?: int,
     *   organizationID?: string|null,
     *   ownerType?: OwnerType|value-of<OwnerType>|null,
     *   page?: string|null,
     *   source?: Source|value-of<Source>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginMarketplaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<PluginMarketplace>>
     *
     * @throws APIException
     */
    public function list(
        array|PluginMarketplaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginMarketplaceListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['limit', 'organizationID', 'ownerType', 'page', 'source']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/plugin_marketplaces?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['organizationID' => 'organization_id', 'ownerType' => 'owner_type'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: PluginMarketplace::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Check whether a plugin marketplace, uploaded as a `.zip` of the marketplace
     * directory, would synchronize into claude.ai, without connecting or storing it.
     *
     * To check a public GitHub repository instead, use Validate Plugin Marketplace Repository.
     *
     * The report says whether `marketplace.json` is well-formed, which plugins a
     * synchronization would skip and why, and which plugins would synchronize only in
     * part, with some files left out. An archive that cannot be read as a marketplace is reported, not refused: the response is a report with `valid: false`. Plugin sources outside the marketplace
     * are fetched anonymously from GitHub, so a private one is reported as not found; a
     * source on any other host is not fetched here, and the report notes that it will be
     * checked when the marketplace actually synchronizes.
     *
     * Nothing is recorded on the Compliance API activity feed.
     *
     * For a worked example, see [Validate marketplace content](/docs/en/manage-claude/plugins-api#validate-marketplace-content)
     * in the Plugins API guide.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `write:plugins` scope; `read:org_audit` and `read:compliance_org_data` do not grant it.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param array{
     *   archive: string|FileParam,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginMarketplaceValidateArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplaceValidationReport>
     *
     * @throws APIException
     */
    public function validateArchive(
        array|PluginMarketplaceValidateArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginMarketplaceValidateArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/plugin_marketplaces/validate_archive?beta=true',
            headers: Util::array_transform_keys(
                [
                    'Content-Type' => 'multipart/form-data',
                    ...array_intersect_key(
                        $parsed,
                        array_flip(array_keys($header_params))
                    ),
                ],
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: PluginMarketplaceValidationReport::class,
        );
    }

    /**
     * @api
     *
     * Check whether a plugin marketplace held in a public GitHub repository would
     * synchronize into claude.ai, without connecting or storing it.
     *
     * To check a `.zip` of the marketplace directory instead, use Validate Plugin Marketplace Archive.
     *
     * The report says whether `marketplace.json` is well-formed, which plugins a
     * synchronization would skip and why, and which plugins would synchronize only in
     * part, with some files left out. A repository that is missing, private, or has no such branch or commit is reported, not refused: the response is a report with `valid: false`. Plugin sources outside the marketplace
     * are fetched anonymously from GitHub, so a private one is reported as not found; a
     * source on any other host is not fetched here, and the report notes that it will be
     * checked when the marketplace actually synchronizes.
     *
     * Nothing is recorded on the Compliance API activity feed.
     *
     * For a worked example, see [Validate marketplace content](/docs/en/manage-claude/plugins-api#validate-marketplace-content)
     * in the Plugins API guide.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `write:plugins` scope; `read:org_audit` and `read:compliance_org_data` do not grant it.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param array{
     *   repositoryURL: string,
     *   ref?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginMarketplaceValidateRepositoryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplaceValidationReport>
     *
     * @throws APIException
     */
    public function validateRepository(
        array|PluginMarketplaceValidateRepositoryParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginMarketplaceValidateRepositoryParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/plugin_marketplaces/validate_repository?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: PluginMarketplaceValidationReport::class,
        );
    }
}
