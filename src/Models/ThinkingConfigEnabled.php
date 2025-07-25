<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type thinking_config_enabled_alias = array{
 *   budgetTokens: int, type: string
 * }
 */
final class ThinkingConfigEnabled implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'enabled';

    /**
     * Determines how many tokens Claude can use for its internal reasoning process. Larger budgets can enable more thorough analysis for complex problems, improving response quality.
     *
     * Must be ≥1024 and less than `max_tokens`.
     *
     * See [extended thinking](https://docs.anthropic.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    #[Api('budget_tokens')]
    public int $budgetTokens;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(int $budgetTokens): self
    {
        $obj = new self;

        $obj->budgetTokens = $budgetTokens;

        return $obj;
    }

    /**
     * Determines how many tokens Claude can use for its internal reasoning process. Larger budgets can enable more thorough analysis for complex problems, improving response quality.
     *
     * Must be ≥1024 and less than `max_tokens`.
     *
     * See [extended thinking](https://docs.anthropic.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    public function setBudgetTokens(int $budgetTokens): self
    {
        $this->budgetTokens = $budgetTokens;

        return $this;
    }
}
