<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_code_execution_tool_result_block_param_alias = array{
 *   content: BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam,
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 * }
 */
final class BetaCodeExecutionToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'code_execution_tool_result';

    #[Api]
    public BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content,
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function setContent(
        BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content,
    ): self {
        $this->content = $content;

        return $this;
    }

    public function setToolUseID(string $toolUseID): self
    {
        $this->toolUseID = $toolUseID;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }
}
