<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaAuthenticationError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'authentication_error';

    #[Api]
    public string $message = 'Authentication error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Authentication error')
    {
        self::introspect();

        $this->message = $message;
    }
}
