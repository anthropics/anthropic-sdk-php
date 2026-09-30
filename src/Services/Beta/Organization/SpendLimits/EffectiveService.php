<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\Effective\EffectiveListParams\Period;
use Anthropic\Beta\Organization\SpendLimits\SpendSummary;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\SpendLimits\EffectiveContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class EffectiveService implements EffectiveContract
{
    /**
     * @api
     */
    public EffectiveRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new EffectiveRawService($client);
    }

    /**
     * @api
     *
     * List each member's effective spend limit and period-to-date spend.
     *
     * Returns one row per (member, period) the member resolves a spend limit
     * for, with the `source` scope the spend limit was inherited from.
     * Paginates by member, so a member's periods never split across pages.
     *
     * @param int $limit Maximum number of members per page. A member's period rows never split across pages, so a page may carry more rows than this. Defaults to `20`.
     * @param string|null $page opaque cursor from a previous response's `next_page` field
     * @param list<Period|value-of<Period>>|null $period Restrict the report to these limit periods. Omit to return one row per period each member resolves a spend limit for.
     * @param list<string>|null $userIDs Restrict the report to these members, by tagged user ID (`user_...`). At most 100 entries.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<SpendSummary>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?array $period = null,
        ?array $userIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'page' => $page,
                'period' => $period,
                'userIDs' => $userIDs,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
