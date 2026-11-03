<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
 *
 * @phpstan-type OrganizationOnHoldErrorDetailsShape = array{
 *   errorCode: 'organization_on_hold', appealURL?: string|null
 * }
 */
final class OrganizationOnHoldErrorDetails implements BaseModel
{
    /** @use SdkModel<OrganizationOnHoldErrorDetailsShape> */
    use SdkModel;

    /** @var 'organization_on_hold' $errorCode */
    #[Required('error_code', type: new ConstantOf('organization_on_hold'))]
    public string $errorCode = 'organization_on_hold';

    #[Optional('appeal_url', nullable: true)]
    public ?string $appealURL;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $appealURL = null): self
    {
        $self = new self;

        null !== $appealURL && $self['appealURL'] = $appealURL;

        return $self;
    }

    /**
     * @param 'organization_on_hold' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withAppealURL(?string $appealURL): self
    {
        $self = clone $this;
        $self['appealURL'] = $appealURL;

        return $self;
    }
}
