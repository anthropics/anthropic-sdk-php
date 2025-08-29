<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type rate_limit_error = array{message: string, type: string}
 */
final class RateLimitError implements BaseModel
{
    /** @use SdkModel<rate_limit_error> */
    use SdkModel;

    #[Api]
    public string $type = 'rate_limit_error';

    #[Api]
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
        $obj = new self;

        $obj->message = $message;

        return $obj;
    }

    public function withMessage(string $message): self
    {
        $obj = clone $this;
        $obj->message = $message;

        return $obj;
    }
}
