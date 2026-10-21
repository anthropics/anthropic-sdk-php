<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List User Profiles.
 *
 * @see Anthropic\Services\UserProfilesService::list()
 *
 * @phpstan-type UserProfileListParamsShape = array{
 *   enforcementStatus?: list<UserProfileEnforcementStatus|value-of<UserProfileEnforcementStatus>>|null,
 *   limit?: int|null,
 *   order?: null|UserProfileListOrder|value-of<UserProfileListOrder>,
 *   orderBy?: null|UserProfileListOrderBy|value-of<UserProfileListOrderBy>,
 *   page?: string|null,
 *   workspaceID?: string|null,
 * }
 */
final class UserProfileListParams implements BaseModel
{
    /** @use SdkModel<UserProfileListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return only the user profiles whose `enforcement_status` is one of these values: `unrestricted`, `pending`, `restricted` or `banned`. Repeat the parameter to match any of several. With it set, a page may hold fewer than `limit` profiles, or none, and still carry a `next_page`: the service examines a bounded number of profiles per request, and only a null `next_page` means the listing is complete. Rejected with `invalid_request_error` under the `user-profiles-2026-09-04` and earlier beta headers. Fails with `overloaded_error` when a profile's enforcement actions cannot be read for the moment.
     *
     * @var list<value-of<UserProfileEnforcementStatus>>|null $enforcementStatus
     */
    #[Optional(list: UserProfileEnforcementStatus::class)]
    public ?array $enforcementStatus;

    /**
     * The maximum number of user profiles to return, from 1 to 100. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * The sort direction, applied to the field that `order_by` selects. Defaults to `desc`.
     *
     * @var value-of<UserProfileListOrder>|null $order
     */
    #[Optional(enum: UserProfileListOrder::class)]
    public ?string $order;

    /**
     * The field to sort user profiles by, in the direction that `order` sets. Defaults to `created_at`.
     *
     * @var value-of<UserProfileListOrderBy>|null $orderBy
     */
    #[Optional(enum: UserProfileListOrderBy::class)]
    public ?string $orderBy;

    /**
     * The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<UserProfileEnforcementStatus|value-of<UserProfileEnforcementStatus>>|null $enforcementStatus
     * @param UserProfileListOrder|value-of<UserProfileListOrder>|null $order
     * @param UserProfileListOrderBy|value-of<UserProfileListOrderBy>|null $orderBy
     */
    public static function with(
        ?array $enforcementStatus = null,
        ?int $limit = null,
        UserProfileListOrder|string|null $order = null,
        UserProfileListOrderBy|string|null $orderBy = null,
        ?string $page = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $enforcementStatus && $self['enforcementStatus'] = $enforcementStatus;
        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $orderBy && $self['orderBy'] = $orderBy;
        null !== $page && $self['page'] = $page;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Return only the user profiles whose `enforcement_status` is one of these values: `unrestricted`, `pending`, `restricted` or `banned`. Repeat the parameter to match any of several. With it set, a page may hold fewer than `limit` profiles, or none, and still carry a `next_page`: the service examines a bounded number of profiles per request, and only a null `next_page` means the listing is complete. Rejected with `invalid_request_error` under the `user-profiles-2026-09-04` and earlier beta headers. Fails with `overloaded_error` when a profile's enforcement actions cannot be read for the moment.
     *
     * @param list<UserProfileEnforcementStatus|value-of<UserProfileEnforcementStatus>> $enforcementStatus
     */
    public function withEnforcementStatus(array $enforcementStatus): self
    {
        $self = clone $this;
        $self['enforcementStatus'] = $enforcementStatus;

        return $self;
    }

    /**
     * The maximum number of user profiles to return, from 1 to 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * The sort direction, applied to the field that `order_by` selects. Defaults to `desc`.
     *
     * @param UserProfileListOrder|value-of<UserProfileListOrder> $order
     */
    public function withOrder(UserProfileListOrder|string $order): self
    {
        $self = clone $this;
        $self['order'] = $order;

        return $self;
    }

    /**
     * The field to sort user profiles by, in the direction that `order` sets. Defaults to `created_at`.
     *
     * @param UserProfileListOrderBy|value-of<UserProfileListOrderBy> $orderBy
     */
    public function withOrderBy(UserProfileListOrderBy|string $orderBy): self
    {
        $self = clone $this;
        $self['orderBy'] = $orderBy;

        return $self;
    }

    /**
     * The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
