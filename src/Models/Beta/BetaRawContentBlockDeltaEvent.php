<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

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
    public static function new(
        BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta,
        int $index,
    ): self {
        $obj = new self;

        $obj->delta = $delta;
        $obj->index = $index;

        return $obj;
    }

    public function setDelta(
        BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta,
    ): self {
        $this->delta = $delta;

        return $this;
    }

    public function setIndex(int $index): self
    {
        $this->index = $index;

        return $this;
    }
}
