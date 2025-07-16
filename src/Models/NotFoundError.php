<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class NotFoundError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'not_found_error';

    #[Api]
    public string $message = 'Not found';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Not found')
    {
        $this->message = $message;
    }
}

NotFoundError::__introspect();
