<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type ToolTextEditor20250124Shape = array{
 *   name: 'str_replace_editor',
 *   type: 'text_editor_20250124',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   strict?: bool|null,
 * }
 */
final class ToolTextEditor20250124 implements BaseModel
{
    /** @use SdkModel<ToolTextEditor20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'str_replace_editor' $name
     */
    #[Required]
    public string $name = 'str_replace_editor';

    /** @var 'text_editor_20250124' $type */
    #[Required]
    public string $type = 'text_editor_20250124';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * When true, guarantees schema validation on tool names and inputs.
     */
    #[Optional]
    public ?bool $strict;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        CacheControlEphemeral|array|null $cacheControl = null,
        ?bool $strict = null
    ): self {
        $self = new self;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $strict && $self['strict'] = $strict;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * When true, guarantees schema validation on tool names and inputs.
     */
    public function withStrict(bool $strict): self
    {
        $self = clone $this;
        $self['strict'] = $strict;

        return $self;
    }
}
