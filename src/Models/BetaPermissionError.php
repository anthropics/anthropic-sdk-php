<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\BetaPermissionError\Type;

final class BetaPermissionError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Permission denied';

    /** @var Type::* $type */
    #[Api]
    public string $type = 'permission_error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $message = 'Permission denied',
        string $type = 'permission_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaPermissionError::_loadMetadata();
