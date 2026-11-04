<?php

declare(strict_types=1);

namespace Anthropic\Organization\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
 *
 * @phpstan-type RBACGroupOwnerAccessUnconfirmedErrorDetailsShape = array{
 *   errorCode: 'rbac_group_owner_access_unconfirmed'
 * }
 */
final class RBACGroupOwnerAccessUnconfirmedErrorDetails implements BaseModel
{
    /** @use SdkModel<RBACGroupOwnerAccessUnconfirmedErrorDetailsShape> */
    use SdkModel;

    /** @var 'rbac_group_owner_access_unconfirmed' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('rbac_group_owner_access_unconfirmed')
    )]
    public string $errorCode = 'rbac_group_owner_access_unconfirmed';

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
     * @param 'rbac_group_owner_access_unconfirmed' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
