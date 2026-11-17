<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaNotFoundErrorObjectShape = array{
 *   message: string, type: 'not_found_error'
 * }
 */
class BetaNotFoundErrorObject implements BaseModel
{
    /** @use SdkModel<BetaNotFoundErrorObjectShape> */
    use SdkModel;

    /**
     * The broad category of the error.
     *
     * @var 'not_found_error' $type
     */
    #[Required(type: new ConstantOf('not_found_error'))]
    public string $type = 'not_found_error';

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaNotFoundErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaNotFoundErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaNotFoundErrorObject())->withMessage(...)
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
    public static function with(string $message = 'Not found'): self
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
     * @param 'not_found_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(BetaNotFoundErrorObject::class, 'Anthropic\Beta\BetaNotFoundError');
