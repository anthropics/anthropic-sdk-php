<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization linked to the request's user profile has reached a spend limit that it set, or lacks credit for the request. The response does not say which applies.
 *
 * @phpstan-type LinkedOrganizationSpendLimitReachedErrorDetailsShape = array{
 *   errorCode: 'linked_organization_spend_limit_reached'
 * }
 */
final class LinkedOrganizationSpendLimitReachedErrorDetails implements BaseModel
{
    /** @use SdkModel<LinkedOrganizationSpendLimitReachedErrorDetailsShape> */
    use SdkModel;

    /** @var 'linked_organization_spend_limit_reached' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('linked_organization_spend_limit_reached'),
    )]
    public string $errorCode = 'linked_organization_spend_limit_reached';

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
     * @param 'linked_organization_spend_limit_reached' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
