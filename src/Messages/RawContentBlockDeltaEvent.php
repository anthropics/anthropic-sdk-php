<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type RawContentBlockDeltaShape from \Anthropic\Messages\RawContentBlockDelta
 *
 * @phpstan-type RawContentBlockDeltaEventShape = array{
 *   delta: TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta|RawContentBlockDeltaShape,
 *   index: int,
 *   type: 'content_block_delta',
 * }
 */
final class RawContentBlockDeltaEvent implements BaseModel
{
    /** @use SdkModel<RawContentBlockDeltaEventShape> */
    use SdkModel;

    /** @var 'content_block_delta' $type */
    #[Required]
    public string $type = 'content_block_delta';

    #[Required(union: RawContentBlockDelta::class)]
    public TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta;

    #[Required]
    public int $index;

    /**
     * `new RawContentBlockDeltaEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RawContentBlockDeltaEvent::with(delta: ..., index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RawContentBlockDeltaEvent)->withDelta(...)->withIndex(...)
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
     * @param RawContentBlockDeltaShape $delta
     */
    public static function with(
        TextDelta|array|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta,
        int $index,
    ): self {
        $self = new self;

        $self['delta'] = $delta;
        $self['index'] = $index;

        return $self;
    }

    /**
     * @param RawContentBlockDeltaShape $delta
     */
    public function withDelta(
        TextDelta|array|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta,
    ): self {
        $self = clone $this;
        $self['delta'] = $delta;

        return $self;
    }

    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }
}
