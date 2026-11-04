<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The endpoint does not support the organization's type. Each endpoint's description says which organization types it supports.
 *
 * @phpstan-type OrganizationTypeNotSupportedErrorDetailsShape = array{
 *   errorCode: 'organization_type_not_supported'
 * }
 */
final class OrganizationTypeNotSupportedErrorDetails implements BaseModel
{
    /** @use SdkModel<OrganizationTypeNotSupportedErrorDetailsShape> */
    use SdkModel;

    /** @var 'organization_type_not_supported' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('organization_type_not_supported')
    )]
    public string $errorCode = 'organization_type_not_supported';

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
     * @param 'organization_type_not_supported' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
