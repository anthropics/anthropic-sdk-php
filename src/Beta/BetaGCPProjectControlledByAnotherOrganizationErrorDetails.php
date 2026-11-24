<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Another organization has data controls turned on for this Google Cloud project, or turned them off recently. The message says how long to wait.
 *
 * @phpstan-type BetaGCPProjectControlledByAnotherOrganizationErrorDetailsShape = array{
 *   errorCode: 'gcp_project_controlled_by_another_organization'
 * }
 */
final class BetaGCPProjectControlledByAnotherOrganizationErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaGCPProjectControlledByAnotherOrganizationErrorDetailsShape> */
    use SdkModel;

    /** @var 'gcp_project_controlled_by_another_organization' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('gcp_project_controlled_by_another_organization'),
    )]
    public string $errorCode = 'gcp_project_controlled_by_another_organization';

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
     * @param 'gcp_project_controlled_by_another_organization' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
