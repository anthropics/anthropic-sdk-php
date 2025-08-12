<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_permission_error_alias = array{message: string, type: string}
 */
final class BetaPermissionError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'permission_error';

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
    public static function from(string $message = 'Permission denied'): self
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
