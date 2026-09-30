<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\Effective\EffectiveListParams;
use Anthropic\Beta\Organization\SpendLimits\Effective\EffectiveListParams\Period;
use Anthropic\Beta\Organization\SpendLimits\SpendSummary;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\SpendLimits\EffectiveRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class EffectiveRawService implements EffectiveRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List each member's effective spend limit and period-to-date spend.
     *
     * Returns one row per (member, period) the member resolves a spend limit
     * for, with the `source` scope the spend limit was inherited from.
     * Paginates by member, so a member's periods never split across pages.
     *
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   period?: list<Period|value-of<Period>>|null,
     *   userIDs?: list<string>|null,
     * }|EffectiveListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SpendSummary>>
     *
     * @throws APIException
     */
    public function list(
        array|EffectiveListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EffectiveListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/spend_limits/effective?beta=true',
            query: Util::array_transform_keys($parsed, ['userIDs' => 'user_ids']),
            options: $options,
            convert: SpendSummary::class,
            page: PageCursor::class,
        );
    }
}
