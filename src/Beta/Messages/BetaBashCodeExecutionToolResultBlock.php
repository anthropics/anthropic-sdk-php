<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultError\ErrorCode;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBashCodeExecutionToolResultBlockShape = array{
 *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock,
 *   tool_use_id: string,
 *   type: 'bash_code_execution_tool_result',
 * }
 */
final class BetaBashCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'bash_code_execution_tool_result' $type */
    #[Api]
    public string $type = 'bash_code_execution_tool_result';

    #[Api]
    public BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock $content;

    #[Api]
    public string $tool_use_id;

    /**
     * `new BetaBashCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionToolResultBlock::with(content: ..., tool_use_id: ...)
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
     *
     * @param BetaBashCodeExecutionToolResultError|array{
     *   error_code: value-of<ErrorCode>, type: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlock|array{
     *   content: list<BetaBashCodeExecutionOutputBlock>,
     *   return_code: int,
     *   stderr: string,
     *   stdout: string,
     *   type: 'bash_code_execution_result',
     * } $content
     */
    public static function with(
        BetaBashCodeExecutionToolResultError|array|BetaBashCodeExecutionResultBlock $content,
        string $tool_use_id,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        return $obj;
    }

    /**
     * @param BetaBashCodeExecutionToolResultError|array{
     *   error_code: value-of<ErrorCode>, type: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlock|array{
     *   content: list<BetaBashCodeExecutionOutputBlock>,
     *   return_code: int,
     *   stderr: string,
     *   stdout: string,
     *   type: 'bash_code_execution_result',
     * } $content
     */
    public function withContent(
        BetaBashCodeExecutionToolResultError|array|BetaBashCodeExecutionResultBlock $content,
    ): self {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }
}
