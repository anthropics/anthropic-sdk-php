<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type overloaded_error = array{message: string, type: string}
 */
final class OverloadedError implements BaseModel
{
    /** @use SdkModel<overloaded_error> */
    use SdkModel;

    #[Api]
    public string $type = 'overloaded_error';

    #[Api]
    public string $message;

    /**
     * `new OverloadedError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OverloadedError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OverloadedError)->withMessage(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $message = 'Overloaded'): self
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
