<?php

declare(strict_types=1);

namespace Anthropic\Organization\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
 *
 * @phpstan-type RBACGroupGrantsOwnerAccessErrorDetailsShape = array{
 *   errorCode: 'rbac_group_grants_owner_access'
 * }
 */
final class RBACGroupGrantsOwnerAccessErrorDetails implements BaseModel
{
    /** @use SdkModel<RBACGroupGrantsOwnerAccessErrorDetailsShape> */
    use SdkModel;

    /** @var 'rbac_group_grants_owner_access' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('rbac_group_grants_owner_access')
    )]
    public string $errorCode = 'rbac_group_grants_owner_access';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'rbac_group_grants_owner_access' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
