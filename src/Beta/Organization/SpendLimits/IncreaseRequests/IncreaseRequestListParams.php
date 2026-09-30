<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\IncreaseRequests;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List spend limit increase requests, most recent first.
 *
 * Pending requests include a live `spend_summary` for the requester.
 * Requests whose requester is no longer a member are excluded.
 *
 * @see Anthropic\Services\Beta\Organization\SpendLimits\IncreaseRequestsService::list()
 *
 * @phpstan-type IncreaseRequestListParamsShape = array{
 *   actorIDs?: list<string>|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   status?: list<BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus>>|null,
 * }
 */
final class IncreaseRequestListParams implements BaseModel
{
    /** @use SdkModel<IncreaseRequestListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filter by requester, as `user_...` tagged IDs.
     *
     * @var list<string>|null $actorIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $actorIDs;

    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Filter by status. Omit to return all.
     *
     * @var list<value-of<BetaSpendLimitIncreaseRequestStatus>>|null $status
     */
    #[Optional(list: BetaSpendLimitIncreaseRequestStatus::class, nullable: true)]
    public ?array $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $actorIDs
     * @param list<BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus>>|null $status
     */
    public static function with(
        ?array $actorIDs = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $status = null,
    ): self {
        $self = new self;

        null !== $actorIDs && $self['actorIDs'] = $actorIDs;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * Filter by requester, as `user_...` tagged IDs.
     *
     * @param list<string>|null $actorIDs
     */
    public function withActorIDs(?array $actorIDs): self
    {
        $self = clone $this;
        $self['actorIDs'] = $actorIDs;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Filter by status. Omit to return all.
     *
     * @param list<BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus>>|null $status
     */
    public function withStatus(?array $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
