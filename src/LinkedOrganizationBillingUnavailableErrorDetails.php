<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic cannot currently bill the organization linked to the request's user profile, for a reason that lies with that organization's own account. The response does not say what the reason is.
 *
 * @phpstan-type LinkedOrganizationBillingUnavailableErrorDetailsShape = array{
 *   errorCode: 'linked_organization_billing_unavailable'
 * }
 */
final class LinkedOrganizationBillingUnavailableErrorDetails implements BaseModel
{
    /** @use SdkModel<LinkedOrganizationBillingUnavailableErrorDetailsShape> */
    use SdkModel;

    /** @var 'linked_organization_billing_unavailable' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('linked_organization_billing_unavailable'),
    )]
    public string $errorCode = 'linked_organization_billing_unavailable';

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
     * @param 'linked_organization_billing_unavailable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
