<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * One of the organization's approvals from Anthropic could not be read right now, so nothing was done. Retry after the `Retry-After` delay.
 *
 * @phpstan-type BetaAuthorizationCheckUnavailableErrorDetailsShape = array{
 *   errorCode: 'authorization_check_unavailable'
 * }
 */
final class BetaAuthorizationCheckUnavailableErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaAuthorizationCheckUnavailableErrorDetailsShape> */
    use SdkModel;

    /** @var 'authorization_check_unavailable' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('authorization_check_unavailable')
    )]
    public string $errorCode = 'authorization_check_unavailable';

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
     * @param 'authorization_check_unavailable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
