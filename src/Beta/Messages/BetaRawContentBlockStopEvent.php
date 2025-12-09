<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawContentBlockStopEventShape = array{
 *   index: int, type?: 'content_block_stop'
 * }
 */
final class BetaRawContentBlockStopEvent implements BaseModel
{
    /** @use SdkModel<BetaRawContentBlockStopEventShape> */
    use SdkModel;

    /** @var 'content_block_stop' $type */
    #[Required]
    public string $type = 'content_block_stop';

    #[Required]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(int $index): self
    {
        $self = new self;

        $self['index'] = $index;

        return $self;
    }

    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }
}
