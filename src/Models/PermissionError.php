<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class PermissionError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'permission_error';

    #[Api]
    public string $message = 'Permission denied';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Permission denied')
    {
        $this->message = $message;
    }
}

PermissionError::_loadMetadata();
