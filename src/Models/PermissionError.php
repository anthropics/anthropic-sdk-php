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
    public string $message = 'Permission denied';

    #[Api]
    public string $type = 'permission_error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $message = 'Permission denied',
        string $type = 'permission_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

PermissionError::_loadMetadata();
