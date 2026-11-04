<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The workspace's encryption settings could not be read, so the request was refused. Retry in a few minutes.
 *
 * @phpstan-type CMEKContextUnavailableErrorDetailsShape = array{
 *   errorCode: 'cmek_context_unavailable'
 * }
 */
final class CMEKContextUnavailableErrorDetails implements BaseModel
{
    /** @use SdkModel<CMEKContextUnavailableErrorDetailsShape> */
    use SdkModel;

    /** @var 'cmek_context_unavailable' $errorCode */
    #[Required('error_code', type: new ConstantOf('cmek_context_unavailable'))]
    public string $errorCode = 'cmek_context_unavailable';

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
     * @param 'cmek_context_unavailable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
