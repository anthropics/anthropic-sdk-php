<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class OverloadedError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Overloaded';

    #[Api]
    public string $type = 'overloaded_error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $message = 'Overloaded',
        string $type = 'overloaded_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

OverloadedError::_loadMetadata();
