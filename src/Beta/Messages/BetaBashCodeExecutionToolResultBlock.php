<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_bash_code_execution_tool_result_block = array{
 *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class BetaBashCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<beta_bash_code_execution_tool_result_block> */
    use SdkModel;

    #[Api]
    public string $type = 'bash_code_execution_tool_result';

    #[Api]
    public BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaBashCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionToolResultBlock)->withContent(...)->withToolUseID(...)
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
        BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock $content,
        string $toolUseID,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    public function withContent(
        BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock $content,
    ): self {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }
}
