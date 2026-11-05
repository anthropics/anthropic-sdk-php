<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaOverloadedErrorShape = array{
 *   message: string, type: 'overloaded_error'
 * }
 */
final class BetaOverloadedError implements BaseModel
{
    /** @use SdkModel<BetaOverloadedErrorShape> */
    use SdkModel;

    /**
     * The broad category of the error.
     *
     * @var 'overloaded_error' $type
     */
    #[Required(type: new ConstantOf('overloaded_error'))]
    public string $type = 'overloaded_error';

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaOverloadedError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaOverloadedError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaOverloadedError())->withMessage(...)
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
    public static function with(string $message = 'Overloaded'): self
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
     * @param 'overloaded_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
