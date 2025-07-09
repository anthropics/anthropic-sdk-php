<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaMessageTokensCount implements BaseModel
{
    use Model;

    #[Api('input_tokens')]
    public int $inputTokens;

    /** @param int $inputTokens */
    final public function __construct($inputTokens)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessageTokensCount::_loadMetadata();
