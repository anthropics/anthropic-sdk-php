<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit;
use Anthropic\Beta\Organization\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RateLimitsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RateLimitsService implements RateLimitsContract
{
    /**
     * @api
     */
    public RateLimitsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RateLimitsRawService($client);
    }

    /**
     * @api
     *
     * List Messages API rate limits for your organization.
     *
     * Each entry corresponds to one rate-limit group (either a model family
     * or an API-surface category such as the Files API or Message Batches)
     * and contains the set of limiter values that apply to it.
     *
     * When `limit` is omitted, every matching entry is returned in a single
     * page; when `limit` truncates the result, follow `next_page` to fetch
     * the remaining entries.
     *
     * @param GroupType|value-of<GroupType>|null $groupType filter by group type
     * @param int|null $limit Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * When omitted, every remaining entry is returned in a single page and `next_page` is `null`.
     * @param string|null $model Filter to the single entry containing this model. Accepts full model names and aliases. Returns 404 if the model is not found or has no rate limits for this organization.
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<OrganizationRateLimit>
     *
     * @throws APIException
     */
    public function list(
        GroupType|string|null $groupType = null,
        ?int $limit = null,
        ?string $model = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'groupType' => $groupType,
                'limit' => $limit,
                'model' => $model,
                'page' => $page,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
