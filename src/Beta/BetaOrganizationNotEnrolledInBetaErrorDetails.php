<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The beta that the endpoint requires is not enabled for the organization. The message names the beta value.
 *
 * @phpstan-type BetaOrganizationNotEnrolledInBetaErrorDetailsShape = array{
 *   errorCode: 'organization_not_enrolled_in_beta'
 * }
 */
final class BetaOrganizationNotEnrolledInBetaErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaOrganizationNotEnrolledInBetaErrorDetailsShape> */
    use SdkModel;

    /** @var 'organization_not_enrolled_in_beta' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('organization_not_enrolled_in_beta')
    )]
    public string $errorCode = 'organization_not_enrolled_in_beta';

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
     * @param 'organization_not_enrolled_in_beta' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
