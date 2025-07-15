<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class AuthenticationError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Authentication error';

    #[Api]
    public string $type = 'authentication_error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $message = 'Authentication error',
        string $type = 'authentication_error',
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

AuthenticationError::_loadMetadata();
