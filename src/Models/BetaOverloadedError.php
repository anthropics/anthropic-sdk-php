<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_overloaded_error_alias = array{message: string, type: string}
 */
final class BetaOverloadedError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'overloaded_error';

    #[Api]
    public string $message;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Overloaded')
    {
        self::introspect();

        $this->message = $message;
    }
}
