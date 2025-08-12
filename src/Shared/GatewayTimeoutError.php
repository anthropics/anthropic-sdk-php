<?php

declare(strict_types=1);

namespace Anthropic\Shared;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type gateway_timeout_error_alias = array{message: string, type: string}
 */
final class GatewayTimeoutError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'timeout_error';

    #[Api]
    public string $message;

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
    public static function new(string $message = 'Request timeout'): self
    {
        $obj = new self;

        $obj->message = $message;

        return $obj;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
