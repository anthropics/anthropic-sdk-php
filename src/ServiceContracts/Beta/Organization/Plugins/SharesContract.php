<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\Shares\BetaPluginShare;
use Anthropic\Beta\Organization\Plugins\Shares\ShareListParams\TargetType;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SharesContract
{
    /**
     * @api
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param string|null $page query param: Optionally set to the `next_page` token from the previous response
     * @param TargetType|value-of<TargetType>|null $targetType query param: Only shares with this kind of target: `organization` (every member), `rbac_group` (one RBAC Group), or `organization_member` (one member)
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaPluginShare>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        ?int $limit = null,
        ?string $organizationID = null,
        ?string $page = null,
        TargetType|string|null $targetType = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
