<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaThinkingDeltaShape = array{
 *   thinking: string, type: 'thinking_delta'
 * }
 */
final class BetaThinkingDelta implements BaseModel
{
    /** @use SdkModel<BetaThinkingDeltaShape> */
    use SdkModel;

    /** @var 'thinking_delta' $type */
    #[Required]
    public string $type = 'thinking_delta';

    #[Required]
    public string $thinking;

    /**
     * `new BetaThinkingDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingDelta::with(thinking: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingDelta)->withThinking(...)
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
    public static function with(string $thinking): self
    {
        $self = new self;

        $self['thinking'] = $thinking;

        return $self;
    }

    public function withThinking(string $thinking): self
    {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }
}
