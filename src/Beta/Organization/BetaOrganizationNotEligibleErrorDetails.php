<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The feature isn't offered to this organization. The error's `message` names the kind of organization or, when it names none, says to contact your Anthropic account team.
 *
 * @phpstan-type BetaOrganizationNotEligibleErrorDetailsShape = array{
 *   errorCode: 'organization_not_eligible'
 * }
 */
final class BetaOrganizationNotEligibleErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaOrganizationNotEligibleErrorDetailsShape> */
    use SdkModel;

    /** @var 'organization_not_eligible' $errorCode */
    #[Required('error_code', type: new ConstantOf('organization_not_eligible'))]
    public string $errorCode = 'organization_not_eligible';

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
     * @param 'organization_not_eligible' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
