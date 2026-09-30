<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\Effective\EffectiveListParams\Period;
use Anthropic\Beta\Organization\SpendLimits\SpendSummary;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface EffectiveContract
{
    /**
     * @api
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
    ): PageCursor;
}
