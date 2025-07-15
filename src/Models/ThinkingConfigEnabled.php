<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ThinkingConfigEnabled implements BaseModel
{
    use Model;

    #[Api('budget_tokens')]
    public int $budgetTokens;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $budgetTokens, string $type)
    {
        $this->budgetTokens = $budgetTokens;
        $this->type = $type;
    }
}

ThinkingConfigEnabled::_loadMetadata();
