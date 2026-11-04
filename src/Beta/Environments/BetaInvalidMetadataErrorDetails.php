<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `metadata` has too many keys, a key or value that is too long, or a reserved key. The message names each problem.
 *
 * @phpstan-type BetaInvalidMetadataErrorDetailsShape = array{
 *   errorCode: 'invalid_metadata'
 * }
 */
final class BetaInvalidMetadataErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaInvalidMetadataErrorDetailsShape> */
    use SdkModel;

    /** @var 'invalid_metadata' $errorCode */
    #[Required('error_code', type: new ConstantOf('invalid_metadata'))]
    public string $errorCode = 'invalid_metadata';

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
     * @param 'invalid_metadata' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
