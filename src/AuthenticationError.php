<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type AuthenticationErrorShape = array{
 *   message: string, type: 'authentication_error'
 * }
 */
final class AuthenticationError implements BaseModel
{
    /** @use SdkModel<AuthenticationErrorShape> */
    use SdkModel;

    /** @var 'authentication_error' $type */
    #[Required]
    public string $type = 'authentication_error';

    #[Required]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $message = 'Authentication error'): self
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
