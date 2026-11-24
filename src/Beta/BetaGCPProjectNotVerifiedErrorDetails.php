<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization has not proved that it owns the Google Cloud project that holds the key or bucket. The message names the field.
 *
 * @phpstan-type BetaGCPProjectNotVerifiedErrorDetailsShape = array{
 *   errorCode: 'gcp_project_not_verified'
 * }
 */
final class BetaGCPProjectNotVerifiedErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaGCPProjectNotVerifiedErrorDetailsShape> */
    use SdkModel;

    /** @var 'gcp_project_not_verified' $errorCode */
    #[Required('error_code', type: new ConstantOf('gcp_project_not_verified'))]
    public string $errorCode = 'gcp_project_not_verified';

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
     * @param 'gcp_project_not_verified' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
