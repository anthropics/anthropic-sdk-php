<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type message_batch_expired_result_alias = array{type: string}
 */
final class MessageBatchExpiredResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'expired';

    final public function __construct()
    {
        self::introspect();
    }
}
