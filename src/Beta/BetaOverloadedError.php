<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaOverloadedErrorShape = array{
 *   message: string, type: 'overloaded_error'
 * }
 */
final class BetaOverloadedError implements BaseModel
{
    /** @use SdkModel<BetaOverloadedErrorShape> */
    use SdkModel;

    /** @var 'overloaded_error' $type */
    #[Required]
    public string $type = 'overloaded_error';

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
     * (new BetaOverloadedError)->withMessage(...)
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

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
