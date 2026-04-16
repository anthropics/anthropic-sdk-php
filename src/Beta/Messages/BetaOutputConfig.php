<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaOutputConfig\Effort;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaJSONOutputFormatShape from \Anthropic\Beta\Messages\BetaJSONOutputFormat
 * @phpstan-import-type BetaTokenTaskBudgetShape from \Anthropic\Beta\Messages\BetaTokenTaskBudget
 *
 * @phpstan-type BetaOutputConfigShape = array{
 *   effort?: null|Effort|value-of<Effort>,
 *   format?: null|BetaJSONOutputFormat|BetaJSONOutputFormatShape,
 *   taskBudget?: null|BetaTokenTaskBudget|BetaTokenTaskBudgetShape,
 * }
 */
final class BetaOutputConfig implements BaseModel
{
    /** @use SdkModel<BetaOutputConfigShape> */
    use SdkModel;

    /**
     * All possible effort levels.
     *
     * @var value-of<Effort>|null $effort
     */
    #[Optional(enum: Effort::class, nullable: true)]
    public ?string $effort;

    /**
     * A schema to specify Claude's output format in responses. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs).
     */
    #[Optional(nullable: true)]
    public ?BetaJSONOutputFormat $format;

    /**
     * User-configurable total token budget across contexts.
     */
    #[Optional('task_budget', nullable: true)]
    public ?BetaTokenTaskBudget $taskBudget;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Effort|value-of<Effort>|null $effort
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $format
     * @param BetaTokenTaskBudget|BetaTokenTaskBudgetShape|null $taskBudget
     */
    public static function with(
        Effort|string|null $effort = null,
        BetaJSONOutputFormat|array|null $format = null,
        BetaTokenTaskBudget|array|null $taskBudget = null,
    ): self {
        $self = new self;

        null !== $effort && $self['effort'] = $effort;
        null !== $format && $self['format'] = $format;
        null !== $taskBudget && $self['taskBudget'] = $taskBudget;

        return $self;
    }

    /**
     * All possible effort levels.
     *
     * @param Effort|value-of<Effort>|null $effort
     */
    public function withEffort(Effort|string|null $effort): self
    {
        $self = clone $this;
        $self['effort'] = $effort;

        return $self;
    }

    /**
     * A schema to specify Claude's output format in responses. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs).
     *
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $format
     */
    public function withFormat(BetaJSONOutputFormat|array|null $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }

    /**
     * User-configurable total token budget across contexts.
     *
     * @param BetaTokenTaskBudget|BetaTokenTaskBudgetShape|null $taskBudget
     */
    public function withTaskBudget(
        BetaTokenTaskBudget|array|null $taskBudget
    ): self {
        $self = clone $this;
        $self['taskBudget'] = $taskBudget;

        return $self;
    }
}
