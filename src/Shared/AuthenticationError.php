<?php

declare(strict_types=1);

namespace Anthropic\Shared;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type authentication_error_alias = array{message: string, type: string}
 */
final class AuthenticationError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'authentication_error';

    #[Api]
    public string $message;

    /**
     * `new AuthenticationError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AuthenticationError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AuthenticationError)->withMessage(...)
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
    public static function with(string $message = 'Authentication error'): self
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
