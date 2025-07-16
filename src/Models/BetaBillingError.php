<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaBillingError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'billing_error';

    #[Api]
    public string $message = 'Billing error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Billing error')
    {
        $this->message = $message;
    }
}

BetaBillingError::_loadMetadata();
