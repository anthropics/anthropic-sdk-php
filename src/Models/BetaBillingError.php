<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\BetaBillingError\Type;

final class BetaBillingError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Billing error';

    /** @var Type::* $type */
    #[Api]
    public string $type = 'billing_error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $message = 'Billing error',
        string $type = 'billing_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaBillingError::_loadMetadata();
