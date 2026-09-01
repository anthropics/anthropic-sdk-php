<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaThinkingConfigAdaptive\Display;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaThinkingBlockBindingShape from \Anthropic\Beta\Messages\BetaThinkingBlockBinding
 *
 * @phpstan-type BetaThinkingConfigAdaptiveShape = array{
 *   type: 'adaptive',
 *   blockBinding?: null|BetaThinkingBlockBinding|BetaThinkingBlockBindingShape,
 *   display?: null|Display|value-of<Display>,
 * }
 */
final class BetaThinkingConfigAdaptive implements BaseModel
{
    /** @use SdkModel<BetaThinkingConfigAdaptiveShape> */
    use SdkModel;

    /** @var 'adaptive' $type */
    #[Required]
    public string $type = 'adaptive';

    /**
     * Controls for block binding: what happens when a thinking block this
     * request sends back fails the conversation check. Every field is optional;
     * an empty object means every default.
     */
    #[Optional('block_binding', nullable: true)]
    public ?BetaThinkingBlockBinding $blockBinding;

    /**
     * Controls how thinking content appears in the response. When set to `summarized`, thinking is returned normally. When set to `omitted`, thinking content is redacted but a signature is returned for multi-turn continuity. Defaults to `summarized`.
     *
     * @var value-of<Display>|null $display
     */
    #[Optional(enum: Display::class, nullable: true)]
    public ?string $display;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaThinkingBlockBinding|BetaThinkingBlockBindingShape|null $blockBinding
     * @param Display|value-of<Display>|null $display
     */
    public static function with(
        BetaThinkingBlockBinding|array|null $blockBinding = null,
        Display|string|null $display = null,
    ): self {
        $self = new self;

        null !== $blockBinding && $self['blockBinding'] = $blockBinding;
        null !== $display && $self['display'] = $display;

        return $self;
    }

    /**
     * @param 'adaptive' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Controls for block binding: what happens when a thinking block this
     * request sends back fails the conversation check. Every field is optional;
     * an empty object means every default.
     *
     * @param BetaThinkingBlockBinding|BetaThinkingBlockBindingShape|null $blockBinding
     */
    public function withBlockBinding(
        BetaThinkingBlockBinding|array|null $blockBinding
    ): self {
        $self = clone $this;
        $self['blockBinding'] = $blockBinding;

        return $self;
    }

    /**
     * Controls how thinking content appears in the response. When set to `summarized`, thinking is returned normally. When set to `omitted`, thinking content is redacted but a signature is returned for multi-turn continuity. Defaults to `summarized`.
     *
     * @param Display|value-of<Display>|null $display
     */
    public function withDisplay(Display|string|null $display): self
    {
        $self = clone $this;
        $self['display'] = $display;

        return $self;
    }
}
