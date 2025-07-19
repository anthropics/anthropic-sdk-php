<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class InvalidRequestError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'invalid_request_error';

    #[Api]
    public string $message;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Invalid request')
    {
        self::introspect();

        $this->message = $message;
    }
}
