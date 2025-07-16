<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaThinkingConfigEnabled implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'enabled';

    #[Api('budget_tokens')]
    public int $budgetTokens;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $budgetTokens)
    {
        $this->budgetTokens = $budgetTokens;

        self::_introspect();
    }
}
