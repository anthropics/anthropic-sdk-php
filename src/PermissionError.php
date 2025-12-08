<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type PermissionErrorShape = array{
 *   message: string, type: 'permission_error'
 * }
 */
final class PermissionError implements BaseModel
{
    /** @use SdkModel<PermissionErrorShape> */
    use SdkModel;

    /** @var 'permission_error' $type */
    #[Required]
    public string $type = 'permission_error';

    #[Required]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $message = 'Permission denied'): self
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
