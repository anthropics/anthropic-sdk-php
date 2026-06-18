<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Marks the point in `content` where one model's output gives way to the next.
 *
 * One block appears per hop where a preceding model actually ran this turn and
 * declined. A turn where no preceding model ran and declined has no such
 * boundary and carries no block — the signal for whether a fallback model
 * served the response is the presence of a `fallback_message` entry in
 * `usage.iterations`, not this block.
 *
 * The block is treated like a server-tool content block for streaming: it
 * arrives via the standard `content_block_start` / `content_block_stop`
 * pair and carries no deltas.
 *
 * @phpstan-import-type BetaFallbackInfoShape from \Anthropic\Beta\Messages\BetaFallbackInfo
 * @phpstan-import-type BetaFallbackRefusalTriggerShape from \Anthropic\Beta\Messages\BetaFallbackRefusalTrigger
 *
 * @phpstan-type BetaFallbackBlockShape = array{
 *   from: BetaFallbackInfo|BetaFallbackInfoShape,
 *   to: BetaFallbackInfo|BetaFallbackInfoShape,
 *   trigger: BetaFallbackRefusalTrigger|BetaFallbackRefusalTriggerShape,
 *   type: 'fallback',
 * }
 */
final class BetaFallbackBlock implements BaseModel
{
    /** @use SdkModel<BetaFallbackBlockShape> */
    use SdkModel;

    /** @var 'fallback' $type */
    #[Required]
    public string $type = 'fallback';

    /**
     * The model whose output ends at this point — the model that declined at this hop. When the declining hop is the requested model, its `model` echoes the top-level `model` string the caller sent (alias or canonical); when the declining hop is a fallback model, its `model` is that model's canonical id.
     */
    #[Required]
    public BetaFallbackInfo $from;

    /**
     * The fallback model producing the content that follows this block. Its `model` is always the canonical id.
     */
    #[Required]
    public BetaFallbackInfo $to;

    /**
     * What caused the `from` model to hand over at this hop.
     */
    #[Required]
    public BetaFallbackRefusalTrigger $trigger;

    /**
     * `new BetaFallbackBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackBlock::with(from: ..., to: ..., trigger: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackBlock)->withFrom(...)->withTo(...)->withTrigger(...)
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
     * @param BetaFallbackInfo|BetaFallbackInfoShape $from
     * @param BetaFallbackInfo|BetaFallbackInfoShape $to
     * @param BetaFallbackRefusalTrigger|BetaFallbackRefusalTriggerShape $trigger
     */
    public static function with(
        BetaFallbackInfo|array $from,
        BetaFallbackInfo|array $to,
        BetaFallbackRefusalTrigger|array $trigger,
    ): self {
        $self = new self;

        $self['from'] = $from;
        $self['to'] = $to;
        $self['trigger'] = $trigger;

        return $self;
    }

    /**
     * The model whose output ends at this point — the model that declined at this hop. When the declining hop is the requested model, its `model` echoes the top-level `model` string the caller sent (alias or canonical); when the declining hop is a fallback model, its `model` is that model's canonical id.
     *
     * @param BetaFallbackInfo|BetaFallbackInfoShape $from
     */
    public function withFrom(BetaFallbackInfo|array $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * The fallback model producing the content that follows this block. Its `model` is always the canonical id.
     *
     * @param BetaFallbackInfo|BetaFallbackInfoShape $to
     */
    public function withTo(BetaFallbackInfo|array $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * What caused the `from` model to hand over at this hop.
     *
     * @param BetaFallbackRefusalTrigger|BetaFallbackRefusalTriggerShape $trigger
     */
    public function withTrigger(BetaFallbackRefusalTrigger|array $trigger): self
    {
        $self = clone $this;
        $self['trigger'] = $trigger;

        return $self;
    }

    /**
     * @param 'fallback' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
