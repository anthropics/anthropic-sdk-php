<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The RBAC Group order already has the most groups allowed. Delete another group's settings first.
 *
 * @phpstan-type BetaRBACGroupOrderLimitExceededErrorDetailsShape = array{
 *   errorCode: 'rbac_group_order_limit_exceeded'
 * }
 */
final class BetaRBACGroupOrderLimitExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaRBACGroupOrderLimitExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'rbac_group_order_limit_exceeded' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('rbac_group_order_limit_exceeded')
    )]
    public string $errorCode = 'rbac_group_order_limit_exceeded';

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
     * @param 'rbac_group_order_limit_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
