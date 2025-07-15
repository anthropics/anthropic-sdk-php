<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRedactedThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $data;

    #[Api]
    public string $type = 'redacted_thinking';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $data,
        string $type = 'redacted_thinking'
    ) {
        $this->data = $data;
        $this->type = $type;
    }
}

BetaRedactedThinkingBlock::_loadMetadata();
