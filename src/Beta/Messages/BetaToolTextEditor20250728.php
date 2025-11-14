<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolTextEditor20250728Shape = array{
 *   name: "str_replace_based_edit_tool",
 *   type: "text_editor_20250728",
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   max_characters?: int|null,
 *   strict?: bool|null,
 * }
 */
final class BetaToolTextEditor20250728 implements BaseModel
{
    /** @use SdkModel<BetaToolTextEditor20250728Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var "str_replace_based_edit_tool" $name
     */
    #[Api]
    public string $name = 'str_replace_based_edit_tool';

    /** @var "text_editor_20250728" $type */
    #[Api]
    public string $type = 'text_editor_20250728';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    #[Api(nullable: true, optional: true)]
    public ?int $max_characters;

    #[Api(optional: true)]
    public ?bool $strict;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?BetaCacheControlEphemeral $cache_control = null,
        ?int $max_characters = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        null !== $cache_control && $obj->cache_control = $cache_control;
        null !== $max_characters && $obj->max_characters = $max_characters;
        null !== $strict && $obj->strict = $strict;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

        return $obj;
    }

    /**
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    public function withMaxCharacters(?int $maxCharacters): self
    {
        $obj = clone $this;
        $obj->max_characters = $maxCharacters;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj->strict = $strict;

        return $obj;
    }
}
