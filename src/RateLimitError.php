<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type RateLimitErrorShape = array{
 *   message: string, type: 'rate_limit_error'
 * }
 */
final class RateLimitError implements BaseModel
{
    /** @use SdkModel<RateLimitErrorShape> */
    use SdkModel;

    /** @var 'rate_limit_error' $type */
    #[Required]
    public string $type = 'rate_limit_error';

    #[Required]
    public string $message;

    /**
     * `new RateLimitError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RateLimitError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RateLimitError)->withMessage(...)
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
    public static function with(string $message = 'Rate limited'): self
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
