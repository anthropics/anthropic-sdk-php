<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ThinkingConfigAdaptive\Display;

/**
 * @phpstan-type ThinkingConfigAdaptiveShape = array{
 *   type: 'adaptive', display?: null|Display|value-of<Display>
 * }
 */
final class ThinkingConfigAdaptive implements BaseModel
{
    /** @use SdkModel<ThinkingConfigAdaptiveShape> */
    use SdkModel;

    /** @var 'adaptive' $type */
    #[Required]
    public string $type = 'adaptive';

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
     * @param Display|value-of<Display>|null $display
     */
    public static function with(Display|string|null $display = null): self
    {
        $self = new self;

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
