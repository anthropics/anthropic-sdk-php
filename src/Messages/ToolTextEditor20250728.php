<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;

/**
 * @phpstan-type ToolTextEditor20250728Shape = array{
 *   name: 'str_replace_based_edit_tool',
 *   type: 'text_editor_20250728',
 *   cache_control?: CacheControlEphemeral|null,
 *   max_characters?: int|null,
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
    #[Api]
    public string $name = 'str_replace_based_edit_tool';

    /** @var 'text_editor_20250728' $type */
    #[Api]
    public string $type = 'text_editor_20250728';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?CacheControlEphemeral $cache_control;

    /**
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    #[Api(nullable: true, optional: true)]
    public ?int $max_characters;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        CacheControlEphemeral|array|null $cache_control = null,
        ?int $max_characters = null,
    ): self {
        $obj = new self;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $max_characters && $obj['max_characters'] = $max_characters;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    public function withMaxCharacters(?int $maxCharacters): self
    {
        $obj = clone $this;
        $obj['max_characters'] = $maxCharacters;

        return $obj;
    }
}
