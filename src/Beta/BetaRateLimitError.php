<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRateLimitErrorShape = array{
 *   message: string, type: 'rate_limit_error'
 * }
 */
final class BetaRateLimitError implements BaseModel
{
    /** @use SdkModel<BetaRateLimitErrorShape> */
    use SdkModel;

    /** @var 'rate_limit_error' $type */
    #[Api]
    public string $type = 'rate_limit_error';

    #[Api]
    public string $message;

    /**
     * `new BetaRateLimitError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRateLimitError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRateLimitError)->withMessage(...)
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

        $obj['message'] = $message;

        return $obj;
    }

    public function withMessage(string $message): self
    {
        $obj = clone $this;
        $obj['message'] = $message;

        return $obj;
    }
}
