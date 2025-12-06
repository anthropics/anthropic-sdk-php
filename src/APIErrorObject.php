<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIErrorObjectShape = array{message: string, type: 'api_error'}
 */
final class APIErrorObject implements BaseModel
{
    /** @use SdkModel<APIErrorObjectShape> */
    use SdkModel;

    /** @var 'api_error' $type */
    #[Api]
    public string $type = 'api_error';

    #[Api]
    public string $message;

    /**
     * `new APIErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIErrorObject)->withMessage(...)
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
    public static function with(string $message = 'Internal server error'): self
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
