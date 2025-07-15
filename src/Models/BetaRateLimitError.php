<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRateLimitError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Rate limited';

    #[Api]
    public string $type = 'rate_limit_error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $message = 'Rate limited',
        string $type = 'rate_limit_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaRateLimitError::_loadMetadata();
