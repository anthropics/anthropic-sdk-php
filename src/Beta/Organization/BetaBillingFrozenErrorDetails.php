<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has temporarily disabled billing changes for the user account the credential belongs to. Contact support.
 *
 * @phpstan-type BetaBillingFrozenErrorDetailsShape = array{
 *   errorCode: 'billing_frozen'
 * }
 */
final class BetaBillingFrozenErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaBillingFrozenErrorDetailsShape> */
    use SdkModel;

    /** @var 'billing_frozen' $errorCode */
    #[Required('error_code', type: new ConstantOf('billing_frozen'))]
    public string $errorCode = 'billing_frozen';

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
     * @param 'billing_frozen' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
