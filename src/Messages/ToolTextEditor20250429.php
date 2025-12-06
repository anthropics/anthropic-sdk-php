<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;

/**
 * @phpstan-type ToolTextEditor20250429Shape = array{
 *   name: 'str_replace_based_edit_tool',
 *   type: 'text_editor_20250429',
 *   cache_control?: CacheControlEphemeral|null,
 * }
 */
final class ToolTextEditor20250429 implements BaseModel
{
    /** @use SdkModel<ToolTextEditor20250429Shape> */
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

    /** @var 'text_editor_20250429' $type */
    #[Api]
    public string $type = 'text_editor_20250429';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?CacheControlEphemeral $cache_control;

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
        CacheControlEphemeral|array|null $cache_control = null
    ): self {
        $obj = new self;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

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
}
