<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_raw_content_block_delta_event_alias = array{
 *   delta: BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta,
 *   index: int,
 *   type: string,
 * }
 */
final class BetaRawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content_block_delta';

    #[Api(union: BetaRawContentBlockDelta::class)]
    public BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta;

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta,
        int $index,
    ): self {
        $obj = new self;

        $obj->delta = $delta;
        $obj->index = $index;

        return $obj;
    }

    public function withDelta(
        BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta,
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
