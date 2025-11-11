<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionTool20250522Shape = array{
 *   name: "code_execution",
 *   type: "code_execution_20250522",
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaCodeExecutionTool20250522 implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionTool20250522Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var "code_execution" $name
     */
    #[Api]
    public string $name = 'code_execution';

    /** @var "code_execution_20250522" $type */
    #[Api]
    public string $type = 'code_execution_20250522';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

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
        ?BetaCacheControlEphemeral $cache_control = null
    ): self {
        $obj = new self;

        null !== $cache_control && $obj->cache_control = $cache_control;

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
}
