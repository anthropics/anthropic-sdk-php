<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionToolResultBlockShape = array{
 *   content: BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock,
 *   tool_use_id: string,
 *   type: 'code_execution_tool_result',
 * }
 */
final class BetaCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result' $type */
    #[Api]
    public string $type = 'code_execution_tool_result';

    #[Api]
    public BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock $content;

    #[Api]
    public string $tool_use_id;

    /**
     * `new BetaCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultBlock::with(content: ..., tool_use_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionToolResultBlock)->withContent(...)->withToolUseID(...)
     * ```
     */
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
        BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock $content,
        string $tool_use_id,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->tool_use_id = $tool_use_id;

        return $obj;
    }

    public function withContent(
        BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock $content
    ): self {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->tool_use_id = $toolUseID;

        return $obj;
    }
}
