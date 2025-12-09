<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawContentBlockDeltaEventShape = array{
 *   delta: BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta,
 *   index: int,
 *   type?: 'content_block_delta',
 * }
 */
final class BetaRawContentBlockDeltaEvent implements BaseModel
{
    /** @use SdkModel<BetaRawContentBlockDeltaEventShape> */
    use SdkModel;

    /** @var 'content_block_delta' $type */
    #[Required]
    public string $type = 'content_block_delta';

    #[Required(union: BetaRawContentBlockDelta::class)]
    public BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta $delta;

    #[Required]
    public int $index;

    /**
     * `new BetaRawContentBlockDeltaEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawContentBlockDeltaEvent::with(delta: ..., index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRawContentBlockDeltaEvent)->withDelta(...)->withIndex(...)
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
     * @param BetaTextDelta|array{
     *   text: string, type?: 'text_delta'
     * }|BetaInputJSONDelta|array{
     *   partialJSON: string, type?: 'input_json_delta'
     * }|BetaCitationsDelta|array{
     *   citation: BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation,
     *   type?: 'citations_delta',
     * }|BetaThinkingDelta|array{
     *   thinking: string, type?: 'thinking_delta'
     * }|BetaSignatureDelta|array{signature: string, type?: 'signature_delta'} $delta
     */
    public static function with(
        BetaTextDelta|array|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta $delta,
        int $index,
    ): self {
        $self = new self;

        $self['delta'] = $delta;
        $self['index'] = $index;

        return $self;
    }

    /**
     * @param BetaTextDelta|array{
     *   text: string, type?: 'text_delta'
     * }|BetaInputJSONDelta|array{
     *   partialJSON: string, type?: 'input_json_delta'
     * }|BetaCitationsDelta|array{
     *   citation: BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation,
     *   type?: 'citations_delta',
     * }|BetaThinkingDelta|array{
     *   thinking: string, type?: 'thinking_delta'
     * }|BetaSignatureDelta|array{signature: string, type?: 'signature_delta'} $delta
     */
    public function withDelta(
        BetaTextDelta|array|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta $delta,
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
