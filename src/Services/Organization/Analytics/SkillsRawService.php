<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Analytics;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\Organization\Analytics\AnalyticsOrder;
use Anthropic\Organization\Analytics\AnalyticsSkillActivity;
use Anthropic\Organization\Analytics\AnalyticsSkillGroupBy;
use Anthropic\Organization\Analytics\Skills\SkillListParams;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Analytics\SkillsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SkillsRawService implements SkillsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get per-skill usage for a given day, with cursor-based pagination.
     *
     * Returns skill usage metrics for the organization, sorted by skill name.
     * Use `group_by[]` to break usage out per member, per RBAC group, or per
     * product surface, and `filter[]` to scope results; the parameter
     * descriptions list the supported dimensions. Available to organizations
     * on a Claude Enterprise plan. Requires an API key with the
     * `read:analytics` scope.
     *
     * @param array{
     *   date?: string|null,
     *   endingDate?: string|null,
     *   filter?: list<string>|null,
     *   groupBy?: list<AnalyticsSkillGroupBy|value-of<AnalyticsSkillGroupBy>>|null,
     *   limit?: int|null,
     *   order?: AnalyticsOrder|value-of<AnalyticsOrder>|null,
     *   orderBy?: string|null,
     *   page?: string|null,
     *   startingDate?: string|null,
     * }|SkillListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsSkillActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|SkillListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SkillListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/skills',
            query: Util::array_transform_keys(
                $parsed,
                [
                    'endingDate' => 'ending_date',
                    'groupBy' => 'group_by',
                    'orderBy' => 'order_by',
                    'startingDate' => 'starting_date',
                ],
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.analytics.skills.list',
                route: '/v1/organizations/analytics/skills',
                query: [
                    'date',
                    'ending_date',
                    'filter',
                    'group_by',
                    'limit',
                    'order',
                    'order_by',
                    'page',
                    'starting_date',
                ],
                contentQuery: ['filter'],
            )),
            convert: AnalyticsSkillActivity::class,
            page: PageCursor::class,
        );
    }
}
