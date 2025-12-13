<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAuthenticationErrorShape = array{
 *   message: string, type?: 'authentication_error'
 * }
 */
final class BetaAuthenticationError implements BaseModel
{
    /** @use SdkModel<BetaAuthenticationErrorShape> */
    use SdkModel;

    /** @var 'authentication_error' $type */
    #[Required]
    public string $type = 'authentication_error';

    #[Required]
    public string $message;

    /**
     * `new BetaAuthenticationError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAuthenticationError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAuthenticationError)->withMessage(...)
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

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
