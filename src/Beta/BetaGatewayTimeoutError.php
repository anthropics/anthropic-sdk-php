<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_gateway_timeout_error_alias = array{
 *   message: string, type: string
 * }
 */
final class BetaGatewayTimeoutError implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'timeout_error';

    #[Api]
    public string $message;

    /**
     * `new BetaGatewayTimeoutError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGatewayTimeoutError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGatewayTimeoutError)->withMessage(...)
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
    public static function with(string $message = 'Request timeout'): self
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
