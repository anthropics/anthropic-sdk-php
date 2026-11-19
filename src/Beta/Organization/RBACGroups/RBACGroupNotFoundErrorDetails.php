<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The RBAC Group is not one of the organization's groups.
 *
 * @phpstan-type RBACGroupNotFoundErrorDetailsShape = array{
 *   errorCode: 'rbac_group_not_found'
 * }
 */
final class RBACGroupNotFoundErrorDetails implements BaseModel
{
    /** @use SdkModel<RBACGroupNotFoundErrorDetailsShape> */
    use SdkModel;

    /** @var 'rbac_group_not_found' $errorCode */
    #[Required('error_code', type: new ConstantOf('rbac_group_not_found'))]
    public string $errorCode = 'rbac_group_not_found';

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
     * @param 'rbac_group_not_found' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
