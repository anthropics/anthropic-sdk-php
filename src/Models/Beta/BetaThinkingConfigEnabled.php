<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled\Type;

final class BetaThinkingConfigEnabled implements BaseModel
{
    use Model;

    #[Api('budget_tokens')]
    public int $budgetTokens;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(int $budgetTokens, string $type)
    {
        $this->budgetTokens = $budgetTokens;
        $this->type = $type;
    }
}

BetaThinkingConfigEnabled::_loadMetadata();
