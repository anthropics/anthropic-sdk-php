<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaInvalidRequestError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Invalid request';

    #[Api]
    public string $type = 'invalid_request_error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $message = 'Invalid request',
        string $type = 'invalid_request_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaInvalidRequestError::_loadMetadata();
