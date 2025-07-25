<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_billing_error_alias = array{message: string, type: string}
 */
final class BetaBillingError implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'billing_error';

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
    public static function new(string $message = 'Billing error'): self
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
