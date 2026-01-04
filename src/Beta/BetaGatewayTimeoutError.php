<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaGatewayTimeoutErrorShape = array{
 *   message: string, type: 'timeout_error'
 * }
 */
final class BetaGatewayTimeoutError implements BaseModel
{
    /** @use SdkModel<BetaGatewayTimeoutErrorShape> */
    use SdkModel;

    /** @var 'timeout_error' $type */
    #[Required]
    public string $type = 'timeout_error';

    #[Required]
    public string $message;

    /**
     * `new BetaGatewayTimeoutError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGatewayTimeoutError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGatewayTimeoutError)->withMessage(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $message = 'Request timeout'): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
