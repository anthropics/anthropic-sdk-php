<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ThinkingConfigEnabled\Display;

/**
 * @phpstan-type ThinkingConfigEnabledShape = array{
 *   budgetTokens: int, type: 'enabled', display?: null|Display|value-of<Display>
 * }
 */
final class ThinkingConfigEnabled implements BaseModel
{
    /** @use SdkModel<ThinkingConfigEnabledShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required]
    public string $type = 'enabled';

    /**
     * Determines how many tokens Claude can use for its internal reasoning process. Larger budgets can enable more thorough analysis for complex problems, improving response quality.
     *
     * Must be ≥1024 and less than `max_tokens`.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    #[Required('budget_tokens')]
    public int $budgetTokens;

    /**
     * Controls how thinking content appears in the response. When set to `summarized`, thinking is returned normally. When set to `omitted`, thinking content is redacted but a signature is returned for multi-turn continuity. Defaults to `summarized`.
     *
     * @var value-of<Display>|null $display
     */
    #[Optional(enum: Display::class, nullable: true)]
    public ?string $display;

    /**
     * `new ThinkingConfigEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThinkingConfigEnabled::with(budgetTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThinkingConfigEnabled)->withBudgetTokens(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Display|value-of<Display>|null $display
     */
    public static function with(
        int $budgetTokens,
        Display|string|null $display = null
    ): self {
        $self = new self;

        $self['budgetTokens'] = $budgetTokens;

        null !== $display && $self['display'] = $display;

        return $self;
    }

    /**
     * Determines how many tokens Claude can use for its internal reasoning process. Larger budgets can enable more thorough analysis for complex problems, improving response quality.
     *
     * Must be ≥1024 and less than `max_tokens`.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    public function withBudgetTokens(int $budgetTokens): self
    {
        $self = clone $this;
        $self['budgetTokens'] = $budgetTokens;

        return $self;
    }

    /**
     * @param 'enabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Controls how thinking content appears in the response. When set to `summarized`, thinking is returned normally. When set to `omitted`, thinking content is redacted but a signature is returned for multi-turn continuity. Defaults to `summarized`.
     *
     * @param Display|value-of<Display>|null $display
     */
    public function withDisplay(Display|string|null $display): self
    {
        $self = clone $this;
        $self['display'] = $display;

        return $self;
    }
}
