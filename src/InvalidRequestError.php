<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type InvalidRequestErrorShape = array{
 *   message: string, type: 'invalid_request_error'
 * }
 */
final class InvalidRequestError implements BaseModel
{
    /** @use SdkModel<InvalidRequestErrorShape> */
    use SdkModel;

    /** @var 'invalid_request_error' $type */
    #[Api]
    public string $type = 'invalid_request_error';

    #[Api]
    public string $message;

    /**
     * `new InvalidRequestError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InvalidRequestError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InvalidRequestError)->withMessage(...)
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
