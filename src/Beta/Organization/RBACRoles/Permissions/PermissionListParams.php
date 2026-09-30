<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the permissions an RBAC Role grants.
 *
 * The RBAC Roles API is available to Claude Enterprise organizations only.
 *
 * @see Anthropic\Services\Beta\Organization\RBACRoles\PermissionsService::list()
 *
 * @phpstan-type PermissionListParamsShape = array{
 *   limit?: int|null, page?: string|null
 * }
 */
final class PermissionListParams implements BaseModel
{
    /** @use SdkModel<PermissionListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $limit = null, ?string $page = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;

        return $self;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
