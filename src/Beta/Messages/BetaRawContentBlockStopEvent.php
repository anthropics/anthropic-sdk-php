<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_raw_content_block_stop_event = array{
 *   index: int, type: string
 * }
 */
final class BetaRawContentBlockStopEvent implements BaseModel
{
    /** @use SdkModel<beta_raw_content_block_stop_event> */
    use SdkModel;

    #[Api]
    public string $type = 'content_block_stop';

    #[Api]
    public int $index;

    /**
     * `new BetaRawContentBlockStopEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawContentBlockStopEvent::with(index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRawContentBlockStopEvent)->withIndex(...)
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
    public static function with(int $index): self
    {
        $obj = new self;

        $obj->index = $index;

        return $obj;
    }

    public function withIndex(int $index): self
    {
        $obj = clone $this;
        $obj->index = $index;

        return $obj;
    }
}
