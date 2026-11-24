<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The External Key is held by a key management service that this endpoint does not take. The message names the field and the service it takes.
 *
 * @phpstan-type BetaExternalKeyProviderMismatchErrorDetailsShape = array{
 *   errorCode: 'external_key_provider_mismatch'
 * }
 */
final class BetaExternalKeyProviderMismatchErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaExternalKeyProviderMismatchErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_key_provider_mismatch' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('external_key_provider_mismatch')
    )]
    public string $errorCode = 'external_key_provider_mismatch';

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
     * @param 'external_key_provider_mismatch' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
