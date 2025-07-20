<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_message_stop_event_alias = array{type: string}
 */
final class RawMessageStopEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_stop';

    final public function __construct()
    {
        self::introspect();
    }
}
