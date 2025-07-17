<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawMessageStopEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_stop';

    final public function __construct()
    {
        self::introspect();
    }
}
