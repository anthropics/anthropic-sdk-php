<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will use any available tools.
 *
 * @phpstan-type beta_tool_choice_any_alias = array{
 *   type: string, disableParallelToolUse?: bool
 * }
 */
final class BetaToolChoiceAny implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'any';

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output exactly one tool use.
     */
    #[Api('disable_parallel_tool_use', optional: true)]
    public ?bool $disableParallelToolUse;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?bool $disableParallelToolUse = null)
    {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $disableParallelToolUse && $this
            ->disableParallelToolUse = $disableParallelToolUse
        ;
    }
}
