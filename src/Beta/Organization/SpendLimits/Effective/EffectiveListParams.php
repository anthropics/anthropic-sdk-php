<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\Effective;

use Anthropic\Beta\Organization\SpendLimits\Effective\EffectiveListParams\Period;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List each member's effective spend limit and period-to-date spend.
 *
 * Returns one row per (member, period) the member resolves a spend limit
 * for, with the `source` scope the spend limit was inherited from.
 * Paginates by member, so a member's periods never split across pages.
 *
 * @see Anthropic\Services\Beta\Organization\SpendLimits\EffectiveService::list()
 *
 * @phpstan-type EffectiveListParamsShape = array{
 *   limit?: int|null,
 *   page?: string|null,
 *   period?: list<Period|value-of<Period>>|null,
 *   userIDs?: list<string>|null,
 * }
 */
final class EffectiveListParams implements BaseModel
{
    /** @use SdkModel<EffectiveListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Maximum number of members per page. A member's period rows never split across pages, so a page may carry more rows than this. Defaults to `20`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page` field.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Restrict the report to these limit periods. Omit to return one row per period each member resolves a spend limit for.
     *
     * @var list<value-of<Period>>|null $period
     */
    #[Optional(list: Period::class, nullable: true)]
    public ?array $period;

    /**
     * Restrict the report to these members, by tagged user ID (`user_...`). At most 100 entries.
     *
     * @var list<string>|null $userIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $userIDs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Period|value-of<Period>>|null $period
     * @param list<string>|null $userIDs
     */
    public static function with(
        ?int $limit = null,
        ?string $page = null,
        ?array $period = null,
        ?array $userIDs = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $period && $self['period'] = $period;
        null !== $userIDs && $self['userIDs'] = $userIDs;

        return $self;
    }

    /**
     * Maximum number of members per page. A member's period rows never split across pages, so a page may carry more rows than this. Defaults to `20`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page` field.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Restrict the report to these limit periods. Omit to return one row per period each member resolves a spend limit for.
     *
     * @param list<Period|value-of<Period>>|null $period
     */
    public function withPeriod(?array $period): self
    {
        $self = clone $this;
        $self['period'] = $period;

        return $self;
    }

    /**
     * Restrict the report to these members, by tagged user ID (`user_...`). At most 100 entries.
     *
     * @param list<string>|null $userIDs
     */
    public function withUserIDs(?array $userIDs): self
    {
        $self = clone $this;
        $self['userIDs'] = $userIDs;

        return $self;
    }
}
