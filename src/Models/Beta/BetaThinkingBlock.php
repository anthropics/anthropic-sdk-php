<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'thinking';

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $signature, string $thinking)
    {
        $this->signature = $signature;
        $this->thinking = $thinking;
    }
}

BetaThinkingBlock::_loadMetadata();
