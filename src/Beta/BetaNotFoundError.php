<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaNotFoundErrorShape = array{
 *   message: string, type?: 'not_found_error'
 * }
 */
final class BetaNotFoundError implements BaseModel
{
    /** @use SdkModel<BetaNotFoundErrorShape> */
    use SdkModel;

    /** @var 'not_found_error' $type */
    #[Required]
    public string $type = 'not_found_error';

    #[Required]
    public string $message;

    /**
     * `new BetaNotFoundError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaNotFoundError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaNotFoundError)->withMessage(...)
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

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
