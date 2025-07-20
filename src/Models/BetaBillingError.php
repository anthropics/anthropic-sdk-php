<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_billing_error_alias = array{message: string, type: string}
 */
final class BetaBillingError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'billing_error';

    #[Api]
    public string $message;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Billing error')
    {
        self::introspect();

        $this->message = $message;
    }
}
