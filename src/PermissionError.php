<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type permission_error = array{message: string, type: string}
 */
final class PermissionError implements BaseModel
{
    /** @use SdkModel<permission_error> */
    use SdkModel;

    #[Api]
    public string $type = 'permission_error';

    #[Api]
    public string $message;

    /**
     * `new PermissionError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PermissionError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PermissionError)->withMessage(...)
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
    public static function with(string $message = 'Permission denied'): self
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
