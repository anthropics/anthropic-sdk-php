<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaAPIError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'api_error';

    #[Api]
    public string $message = 'Internal server error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Internal server error')
    {
        $this->message = $message;
    }
}

BetaAPIError::_loadMetadata();
