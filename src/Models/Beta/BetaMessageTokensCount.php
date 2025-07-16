<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaMessageTokensCount implements BaseModel
{
    use Model;

    #[Api('input_tokens')]
    public int $inputTokens;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $inputTokens)
    {
        $this->inputTokens = $inputTokens;
    }
}

BetaMessageTokensCount::__introspect();
