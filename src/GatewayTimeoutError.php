<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type GatewayTimeoutErrorShape = array{
 *   message: string, type?: 'timeout_error'
 * }
 */
final class GatewayTimeoutError implements BaseModel
{
    /** @use SdkModel<GatewayTimeoutErrorShape> */
    use SdkModel;

    /** @var 'timeout_error' $type */
    #[Required]
    public string $type = 'timeout_error';

    #[Required]
    public string $message;

    /**
     * `new GatewayTimeoutError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GatewayTimeoutError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GatewayTimeoutError)->withMessage(...)
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
