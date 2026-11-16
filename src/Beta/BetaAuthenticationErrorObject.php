<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaAuthenticationErrorObjectShape = array{
 *   message: string, type: 'authentication_error'
 * }
 */
class BetaAuthenticationErrorObject implements BaseModel
{
    /** @use SdkModel<BetaAuthenticationErrorObjectShape> */
    use SdkModel;

    /**
     * The broad category of the error.
     *
     * @var 'authentication_error' $type
     */
    #[Required(type: new ConstantOf('authentication_error'))]
    public string $type = 'authentication_error';

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaAuthenticationErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAuthenticationErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAuthenticationErrorObject())->withMessage(...)
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
    public static function with(string $message = 'Authentication error'): self
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
     * @param 'authentication_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaAuthenticationErrorObject::class,
    'Anthropic\Beta\BetaAuthenticationError'
);
