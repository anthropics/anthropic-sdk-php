<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Automatically compact older context when reaching the configured trigger threshold.
 *
 * @phpstan-import-type BetaInputTokensTriggerShape from \Anthropic\Beta\Messages\BetaInputTokensTrigger
 *
 * @phpstan-type BetaCompact20260112EditShape = array{
 *   type: 'compact_20260112',
 *   instructions?: string|null,
 *   pauseAfterCompaction?: bool|null,
 *   trigger?: null|BetaInputTokensTrigger|BetaInputTokensTriggerShape,
 * }
 */
final class BetaCompact20260112Edit implements BaseModel
{
    /** @use SdkModel<BetaCompact20260112EditShape> */
    use SdkModel;

    /** @var 'compact_20260112' $type */
    #[Required]
    public string $type = 'compact_20260112';

    /**
     * Additional instructions for summarization.
     */
    #[Optional(nullable: true)]
    public ?string $instructions;

    /**
     * Whether to pause after compaction and return the compaction block to the user.
     */
    #[Optional('pause_after_compaction')]
    public ?bool $pauseAfterCompaction;

    /**
     * When to trigger compaction. Defaults to 150000 input tokens.
     */
    #[Optional(nullable: true)]
    public ?BetaInputTokensTrigger $trigger;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaInputTokensTrigger|BetaInputTokensTriggerShape|null $trigger
     */
    public static function with(
        ?string $instructions = null,
        ?bool $pauseAfterCompaction = null,
        BetaInputTokensTrigger|array|null $trigger = null,
    ): self {
        $self = new self;

        null !== $instructions && $self['instructions'] = $instructions;
        null !== $pauseAfterCompaction && $self['pauseAfterCompaction'] = $pauseAfterCompaction;
        null !== $trigger && $self['trigger'] = $trigger;

        return $self;
    }

    /**
     * @param 'compact_20260112' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Additional instructions for summarization.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * Whether to pause after compaction and return the compaction block to the user.
     */
    public function withPauseAfterCompaction(bool $pauseAfterCompaction): self
    {
        $self = clone $this;
        $self['pauseAfterCompaction'] = $pauseAfterCompaction;

        return $self;
    }

    /**
     * When to trigger compaction. Defaults to 150000 input tokens.
     *
     * @param BetaInputTokensTrigger|BetaInputTokensTriggerShape|null $trigger
     */
    public function withTrigger(
        BetaInputTokensTrigger|array|null $trigger
    ): self {
        $self = clone $this;
        $self['trigger'] = $trigger;

        return $self;
    }
}
