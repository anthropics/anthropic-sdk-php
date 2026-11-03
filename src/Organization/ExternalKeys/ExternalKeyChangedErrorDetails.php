<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The external key changed while the request was validating it. Send the request again.
 *
 * @phpstan-type ExternalKeyChangedErrorDetailsShape = array{
 *   errorCode: 'external_key_changed'
 * }
 */
final class ExternalKeyChangedErrorDetails implements BaseModel
{
    /** @use SdkModel<ExternalKeyChangedErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_key_changed' $errorCode */
    #[Required('error_code', type: new ConstantOf('external_key_changed'))]
    public string $errorCode = 'external_key_changed';

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
     * @param 'external_key_changed' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
