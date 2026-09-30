<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Update an RBAC Group's name. Groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
 *
 * The RBAC Groups API is available to Claude Enterprise organizations only.
 *
 * @see Anthropic\Services\Beta\Organization\RBACGroupsService::update()
 *
 * @phpstan-type RBACGroupUpdateParamsShape = array{name?: string|null}
 */
final class RBACGroupUpdateParams implements BaseModel
{
    /** @use SdkModel<RBACGroupUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Name of the RBAC Group. Not uniqueness-enforced.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $name = null): self
    {
        $self = new self;

        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * Name of the RBAC Group. Not uniqueness-enforced.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
