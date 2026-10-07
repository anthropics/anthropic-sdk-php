<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Summaries;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get organization-wide activity summaries for a date range.
 *
 * Returns one entry per day from `starting_date` (inclusive) to `ending_date`
 * (exclusive) in `data`, the same `data` / `next_page` envelope as the other
 * analytics list endpoints; the series is currently returned in full, so
 * `next_page` is always null.
 * Data is typically available with a 1-day lag and may be revised by a few
 * percent over the following days: when `ending_date` is omitted it
 * defaults to the most recent available day + 1, so the last entry covers
 * the most recent available day. The series can be scoped to an RBAC group
 * via `filter[]=rbac_group_id:{id}`. Available to organizations on a Claude
 * Enterprise plan. Requires an API key with the `read:analytics` scope.
 *
 * @see Anthropic\Services\Beta\Organization\Analytics\SummariesService::list()
 *
 * @phpstan-type SummaryListParamsShape = array{
 *   startingDate: string,
 *   endingDate?: string|null,
 *   filter?: list<string>|null,
 *   limit?: int|null,
 *   page?: string|null,
 * }
 */
final class SummaryListParams implements BaseModel
{
    /** @use SdkModel<SummaryListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * UTC date in YYYY-MM-DD format. Start of the date range (inclusive). Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     */
    #[Required]
    public string $startingDate;

    /**
     * UTC date in YYYY-MM-DD format. End of the date range (exclusive). Data is typically available with a 1-day lag, so this can be at most today — which is also the default when omitted, making the last entry cover the most recent available day. Data may be revised by a few percent over the following days. The range may span at most 366 days.
     */
    #[Optional(nullable: true)]
    public ?string $endingDate;

    /**
     * Filters as `dimension:value`. Only `rbac_group_id` is supported (e.g. `filter[]=rbac_group_id:{id}`); repeat the param to OR across groups. Scopes the whole day series to members of the matching group(s), re-aggregated from member-level activity — org-wide seat/invite fields and the adoption rates derived from them are null on scoped rows. `rbac_group_id` accepts the tagged id (`rbac_group_...`, as emitted in responses and by the spend-limits API) or a bare group UUID, and matches users who held the group at any point during each UTC day (time-of-usage attribution). At most 100 entries.
     *
     * @var list<string>|null $filter
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $filter;

    /**
     * Number of results per page (1-1000, default 100). The day series (at most 366 entries) is currently returned in full in a single page, so `limit` does not yet shorten it.
     */
    #[Optional(nullable: true)]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page` field. `next_page` is currently always null, so there is never a cursor to send.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * `new SummaryListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SummaryListParams::with(startingDate: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SummaryListParams())->withStartingDate(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $filter
     */
    public static function with(
        string $startingDate,
        ?string $endingDate = null,
        ?array $filter = null,
        ?int $limit = null,
        ?string $page = null,
    ): self {
        $self = new self;

        $self['startingDate'] = $startingDate;

        null !== $endingDate && $self['endingDate'] = $endingDate;
        null !== $filter && $self['filter'] = $filter;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;

        return $self;
    }

    /**
     * UTC date in YYYY-MM-DD format. Start of the date range (inclusive). Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     */
    public function withStartingDate(string $startingDate): self
    {
        $self = clone $this;
        $self['startingDate'] = $startingDate;

        return $self;
    }

    /**
     * UTC date in YYYY-MM-DD format. End of the date range (exclusive). Data is typically available with a 1-day lag, so this can be at most today — which is also the default when omitted, making the last entry cover the most recent available day. Data may be revised by a few percent over the following days. The range may span at most 366 days.
     */
    public function withEndingDate(?string $endingDate): self
    {
        $self = clone $this;
        $self['endingDate'] = $endingDate;

        return $self;
    }

    /**
     * Filters as `dimension:value`. Only `rbac_group_id` is supported (e.g. `filter[]=rbac_group_id:{id}`); repeat the param to OR across groups. Scopes the whole day series to members of the matching group(s), re-aggregated from member-level activity — org-wide seat/invite fields and the adoption rates derived from them are null on scoped rows. `rbac_group_id` accepts the tagged id (`rbac_group_...`, as emitted in responses and by the spend-limits API) or a bare group UUID, and matches users who held the group at any point during each UTC day (time-of-usage attribution). At most 100 entries.
     *
     * @param list<string>|null $filter
     */
    public function withFilter(?array $filter): self
    {
        $self = clone $this;
        $self['filter'] = $filter;

        return $self;
    }

    /**
     * Number of results per page (1-1000, default 100). The day series (at most 366 entries) is currently returned in full in a single page, so `limit` does not yet shorten it.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page` field. `next_page` is currently always null, so there is never a cursor to send.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
