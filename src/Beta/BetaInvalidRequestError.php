<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaInvalidRequestErrorShape = array{
 *   message: string, type: 'invalid_request_error'
 * }
 */
final class BetaInvalidRequestError implements BaseModel
{
    /** @use SdkModel<BetaInvalidRequestErrorShape> */
    use SdkModel;

    /** @var 'invalid_request_error' $type */
    #[Api]
    public string $type = 'invalid_request_error';

    #[Api]
    public string $message;

    /**
     * `new BetaInvalidRequestError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaInvalidRequestError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaInvalidRequestError)->withMessage(...)
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
    public static function with(string $message = 'Invalid request'): self
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
