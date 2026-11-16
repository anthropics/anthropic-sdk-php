<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The endpoint serves only organizations that belong to a parent organization, and this organization belongs to none.
 *
 * @phpstan-type ParentOrganizationRequiredErrorDetailsShape = array{
 *   errorCode: 'parent_organization_required'
 * }
 */
final class ParentOrganizationRequiredErrorDetails implements BaseModel
{
    /** @use SdkModel<ParentOrganizationRequiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'parent_organization_required' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('parent_organization_required')
    )]
    public string $errorCode = 'parent_organization_required';

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
     * @param 'parent_organization_required' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
