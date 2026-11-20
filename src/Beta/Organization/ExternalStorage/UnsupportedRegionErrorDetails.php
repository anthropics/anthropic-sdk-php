<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `provider_config.region` is not a region where External Storage is available.
 *
 * @phpstan-type UnsupportedRegionErrorDetailsShape = array{
 *   errorCode: 'unsupported_region'
 * }
 */
final class UnsupportedRegionErrorDetails implements BaseModel
{
    /** @use SdkModel<UnsupportedRegionErrorDetailsShape> */
    use SdkModel;

    /** @var 'unsupported_region' $errorCode */
    #[Required('error_code', type: new ConstantOf('unsupported_region'))]
    public string $errorCode = 'unsupported_region';

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
     * @param 'unsupported_region' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
