<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Compact the whole conversation and return a signed `compaction` block,
 * alone, that a later request sends back first in `messages`, in place of
 * the messages it summarizes. There is no trigger and no pause flag: sending
 * the parameter compacts, and nothing is sampled after the block.
 *
 * The summarization prompt is the server's own unless `instructions` are
 * given, which then replace it for this request; a value that is empty or
 * only whitespace counts as absent.
 *
 * @phpstan-type BetaCompactionConfigShape = array{
 *   type: 'summarize', instructions?: string|null
 * }
 */
final class BetaCompactionConfig implements BaseModel
{
    /** @use SdkModel<BetaCompactionConfigShape> */
    use SdkModel;

    /** @var 'summarize' $type */
    #[Required]
    public string $type = 'summarize';

    /**
     * Replaces the server's default summarization prompt for this request. An empty or whitespace-only value counts as absent.
     */
    #[Optional(nullable: true)]
    public ?string $instructions;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $instructions = null): self
    {
        $self = new self;

        null !== $instructions && $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * @param 'summarize' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Replaces the server's default summarization prompt for this request. An empty or whitespace-only value counts as absent.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }
}
