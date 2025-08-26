<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_content_block_delta_event = array{
 *   delta: TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta,
 *   index: int,
 *   type: string,
 * }
 */
final class RawContentBlockDeltaEvent implements BaseModel
{
    /** @use SdkModel<raw_content_block_delta_event> */
    use SdkModel;

    #[Api]
    public string $type = 'content_block_delta';

    #[Api(union: RawContentBlockDelta::class)]
    public TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta;

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta,
        int $index,
    ): self {
        $obj = new self;

        $obj->delta = $delta;
        $obj->index = $index;

        return $obj;
    }

    public function withDelta(
        TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta
    ): self {
        $obj = clone $this;
        $obj->delta = $delta;

        return $obj;
    }

    public function withIndex(int $index): self
    {
        $obj = clone $this;
        $obj->index = $index;

        return $obj;
    }
}
