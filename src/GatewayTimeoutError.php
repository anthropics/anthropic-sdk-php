<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type GatewayTimeoutErrorShape = array{
 *   message: string, type: 'timeout_error'
 * }
 */
final class GatewayTimeoutError implements BaseModel
{
    /** @use SdkModel<GatewayTimeoutErrorShape> */
    use SdkModel;

    /**
     * The broad category of the error.
     *
     * @var 'timeout_error' $type
     */
    #[Required(type: new ConstantOf('timeout_error'))]
    public string $type = 'timeout_error';

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     */
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
     * (new GatewayTimeoutError())->withMessage(...)
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

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * The broad category of the error.
     *
     * @param 'timeout_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
