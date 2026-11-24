<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization has no active External Key with this ID. The message names the field.
 *
 * @phpstan-type BetaExternalKeyNotFoundErrorDetailsShape = array{
 *   errorCode: 'external_key_not_found'
 * }
 */
final class BetaExternalKeyNotFoundErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaExternalKeyNotFoundErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_key_not_found' $errorCode */
    #[Required('error_code', type: new ConstantOf('external_key_not_found'))]
    public string $errorCode = 'external_key_not_found';

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
     * @param 'external_key_not_found' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
