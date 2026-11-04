<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization's compliance configuration does not let Claude Tag store anything new.
 *
 * @phpstan-type ComplianceConfigurationRestrictedErrorDetailsShape = array{
 *   errorCode: 'compliance_configuration_restricted'
 * }
 */
final class ComplianceConfigurationRestrictedErrorDetails implements BaseModel
{
    /** @use SdkModel<ComplianceConfigurationRestrictedErrorDetailsShape> */
    use SdkModel;

    /** @var 'compliance_configuration_restricted' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('compliance_configuration_restricted')
    )]
    public string $errorCode = 'compliance_configuration_restricted';

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
     * @param 'compliance_configuration_restricted' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
