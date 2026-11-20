<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request can't use External Storage on this cloud provider. The error's message says why.
 *
 * @phpstan-type ProviderNotAllowedErrorDetailsShape = array{
 *   errorCode: 'provider_not_allowed'
 * }
 */
final class ProviderNotAllowedErrorDetails implements BaseModel
{
    /** @use SdkModel<ProviderNotAllowedErrorDetailsShape> */
    use SdkModel;

    /** @var 'provider_not_allowed' $errorCode */
    #[Required('error_code', type: new ConstantOf('provider_not_allowed'))]
    public string $errorCode = 'provider_not_allowed';

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
     * @param 'provider_not_allowed' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
