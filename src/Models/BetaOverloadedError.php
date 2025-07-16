<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaOverloadedError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'overloaded_error';

    #[Api]
    public string $message = 'Overloaded';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Overloaded')
    {
        $this->message = $message;
    }
}

BetaOverloadedError::_loadMetadata();
