<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\Shares\BetaPluginShare;
use Anthropic\Beta\Organization\Plugins\Shares\ShareListParams;
use Anthropic\Beta\Organization\Plugins\Shares\ShareListParams\TargetType;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Plugins\SharesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SharesRawService implements SharesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List the shares the owner of a member-owned Plugin has given — to every member of
     * the organization, to an RBAC Group, or to one member — most recently granted first.
     *
     * Shares are read-only in this API: members give and withdraw them in claude.ai, and
     * who gave a share is recorded on the Compliance API activity feed rather than on the
     * share. An organization-owned Plugin has installation settings instead, so this path
     * returns 404 for one.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param array{
     *   limit?: int,
     *   organizationID?: string|null,
     *   page?: string|null,
     *   targetType?: TargetType|value-of<TargetType>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ShareListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaPluginShare>>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        array|ShareListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ShareListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['limit', 'organizationID', 'page', 'targetType']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/plugins/%1$s/shares?beta=true', $pluginID],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['organizationID' => 'organization_id', 'targetType' => 'target_type'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: BetaPluginShare::class,
            page: PageCursor::class,
        );
    }
}
