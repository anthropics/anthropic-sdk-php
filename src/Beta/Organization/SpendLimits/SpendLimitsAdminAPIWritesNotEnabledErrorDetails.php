<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization cannot retrieve, set or delete spend limits with an Admin API credential.
 *
 * @phpstan-type SpendLimitsAdminAPIWritesNotEnabledErrorDetailsShape = array{
 *   errorCode: 'spend_limits_admin_api_writes_not_enabled'
 * }
 */
final class SpendLimitsAdminAPIWritesNotEnabledErrorDetails implements BaseModel
{
    /** @use SdkModel<SpendLimitsAdminAPIWritesNotEnabledErrorDetailsShape> */
    use SdkModel;

    /** @var 'spend_limits_admin_api_writes_not_enabled' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('spend_limits_admin_api_writes_not_enabled'),
    )]
    public string $errorCode = 'spend_limits_admin_api_writes_not_enabled';

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
     * @param 'spend_limits_admin_api_writes_not_enabled' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
