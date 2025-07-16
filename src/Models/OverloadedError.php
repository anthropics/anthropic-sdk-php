<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\OverloadedError\Type;

final class OverloadedError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Overloaded';

    /** @var Type::* $type */
    #[Api]
    public string $type = 'overloaded_error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
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
