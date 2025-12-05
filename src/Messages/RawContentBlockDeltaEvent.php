<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type RawContentBlockDeltaEventShape = array{
 *   delta: TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta,
 *   index: int,
 *   type: 'content_block_delta',
 * }
 */
final class RawContentBlockDeltaEvent implements BaseModel
{
    /** @use SdkModel<RawContentBlockDeltaEventShape> */
    use SdkModel;

    /** @var 'content_block_delta' $type */
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TextDelta|array{text: string, type: 'text_delta'}|InputJSONDelta|array{
     *   partial_json: string, type: 'input_json_delta'
     * }|CitationsDelta|array{
     *   citation: CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation,
     *   type: 'citations_delta',
     * }|ThinkingDelta|array{
     *   thinking: string, type: 'thinking_delta'
     * }|SignatureDelta|array{signature: string, type: 'signature_delta'} $delta
     */
    public static function with(
        TextDelta|array|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta,
        int $index,
    ): self {
        $obj = new self;

        $obj['delta'] = $delta;
        $obj['index'] = $index;

        return $obj;
    }

    /**
     * @param TextDelta|array{text: string, type: 'text_delta'}|InputJSONDelta|array{
     *   partial_json: string, type: 'input_json_delta'
     * }|CitationsDelta|array{
     *   citation: CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation,
     *   type: 'citations_delta',
     * }|ThinkingDelta|array{
     *   thinking: string, type: 'thinking_delta'
     * }|SignatureDelta|array{signature: string, type: 'signature_delta'} $delta
     */
    public function withDelta(
        TextDelta|array|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta $delta,
    ): self {
        $obj = clone $this;
        $obj['delta'] = $delta;

        return $obj;
    }

    public function withIndex(int $index): self
    {
        $obj = clone $this;
        $obj['index'] = $index;

        return $obj;
    }
}
