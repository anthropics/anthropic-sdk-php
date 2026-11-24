<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request names a region code that the control does not take from this organization. The message names the field.
 *
 * @phpstan-type BetaRegionNotSupportedErrorDetailsShape = array{
 *   errorCode: 'region_not_supported'
 * }
 */
final class BetaRegionNotSupportedErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaRegionNotSupportedErrorDetailsShape> */
    use SdkModel;

    /** @var 'region_not_supported' $errorCode */
    #[Required('error_code', type: new ConstantOf('region_not_supported'))]
    public string $errorCode = 'region_not_supported';

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
     * @param 'region_not_supported' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
