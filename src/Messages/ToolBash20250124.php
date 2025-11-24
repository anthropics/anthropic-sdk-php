<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ToolBash20250124Shape = array{
 *   name: "bash",
 *   type: "bash_20250124",
 *   cache_control?: CacheControlEphemeral|null,
 * }
 */
final class ToolBash20250124 implements BaseModel
{
    /** @use SdkModel<ToolBash20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var "bash" $name
     */
    #[Api]
    public string $name = 'bash';

    /** @var "bash_20250124" $type */
    #[Api]
    public string $type = 'bash_20250124';

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
     */
    public static function with(
        ?CacheControlEphemeral $cache_control = null
    ): self {
        $obj = new self;

        null !== $cache_control && $obj->cache_control = $cache_control;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(?CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

        return $obj;
    }
}
