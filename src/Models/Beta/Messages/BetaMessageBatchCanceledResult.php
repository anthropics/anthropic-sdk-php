<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaMessageBatchCanceledResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'canceled';

    final public function __construct() {}
}

BetaMessageBatchCanceledResult::_loadMetadata();
