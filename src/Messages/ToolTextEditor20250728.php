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
 * @phpstan-type ToolTextEditor20250728Shape = array{
 *   name: 'str_replace_based_edit_tool',
 *   type: 'text_editor_20250728',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   maxCharacters?: int|null,
 *   strict?: bool|null,
 * }
 */
final class ToolTextEditor20250728 implements BaseModel
{
    /** @use SdkModel<ToolTextEditor20250728Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'str_replace_based_edit_tool' $name
     */
    #[Required]
    public string $name = 'str_replace_based_edit_tool';

    /** @var 'text_editor_20250728' $type */
    #[Required]
    public string $type = 'text_editor_20250728';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    #[Optional('max_characters', nullable: true)]
    public ?int $maxCharacters;

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
        ?int $maxCharacters = null,
        ?bool $strict = null,
    ): self {
        $self = new self;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $maxCharacters && $self['maxCharacters'] = $maxCharacters;
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
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    public function withMaxCharacters(?int $maxCharacters): self
    {
        $self = clone $this;
        $self['maxCharacters'] = $maxCharacters;

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
