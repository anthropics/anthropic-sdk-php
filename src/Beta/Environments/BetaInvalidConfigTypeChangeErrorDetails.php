<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `config.type` differs from the environment's stored type, which cannot change after creation.
 *
 * @phpstan-type BetaInvalidConfigTypeChangeErrorDetailsShape = array{
 *   errorCode: 'invalid_config_type_change'
 * }
 */
final class BetaInvalidConfigTypeChangeErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaInvalidConfigTypeChangeErrorDetailsShape> */
    use SdkModel;

    /** @var 'invalid_config_type_change' $errorCode */
    #[Required('error_code', type: new ConstantOf('invalid_config_type_change'))]
    public string $errorCode = 'invalid_config_type_change';

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
     * @param 'invalid_config_type_change' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
