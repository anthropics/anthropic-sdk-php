<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_content_block_delta_event_alias = array{
 *   delta: TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta,
 *   index: int,
 *   type: string,
 * }
 */
final class RawContentBlockDeltaEvent implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'content_block_delta';

    #[Api(union: RawContentBlockDelta::class)]
    public CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta;

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
        CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta,
        int $index,
    ): self {
        $obj = new self;

        $obj->delta = $delta;
        $obj->index = $index;

        return $obj;
    }

    public function setDelta(
        CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta
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
