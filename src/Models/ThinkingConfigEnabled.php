<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class ThinkingConfigEnabled implements BaseModel
{
    use Model;

    #[Api('budget_tokens')]
    public int $budgetTokens;

    #[Api]
    public string $type;

    /**
     * @param int    $budgetTokens
     * @param string $type
     */
    final public function __construct($budgetTokens, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

ThinkingConfigEnabled::_loadMetadata();
