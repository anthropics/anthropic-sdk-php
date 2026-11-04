<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has turned off creating environments for this organization. Existing environments still work.
 *
 * @phpstan-type BetaEnvironmentCreateDisabledErrorDetailsShape = array{
 *   errorCode: 'environment_create_disabled'
 * }
 */
final class BetaEnvironmentCreateDisabledErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaEnvironmentCreateDisabledErrorDetailsShape> */
    use SdkModel;

    /** @var 'environment_create_disabled' $errorCode */
    #[Required('error_code', type: new ConstantOf('environment_create_disabled'))]
    public string $errorCode = 'environment_create_disabled';

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
     * @param 'environment_create_disabled' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
