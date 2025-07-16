<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class GatewayTimeoutError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'timeout_error';

    #[Api]
    public string $message = 'Request timeout';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Request timeout')
    {
        $this->message = $message;
    }
}

GatewayTimeoutError::_loadMetadata();
