<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_permission_error_alias = array{message: string, type: string}
 */
final class BetaPermissionError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'permission_error';

    #[Api]
    public string $message;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $message = 'Permission denied')
    {
        self::introspect();

        $this->message = $message;
    }
}
