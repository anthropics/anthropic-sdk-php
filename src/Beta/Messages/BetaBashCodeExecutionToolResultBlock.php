<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultError\ErrorCode;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBashCodeExecutionToolResultBlockShape = array{
 *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock,
 *   toolUseID: string,
 *   type?: 'bash_code_execution_tool_result',
 * }
 */
final class BetaBashCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'bash_code_execution_tool_result' $type */
    #[Required]
    public string $type = 'bash_code_execution_tool_result';

    #[Required]
    public BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock $content;

    #[Required('tool_use_id')]
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
     *
     * @param BetaBashCodeExecutionToolResultError|array{
     *   errorCode: value-of<ErrorCode>, type?: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlock|array{
     *   content: list<BetaBashCodeExecutionOutputBlock>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'bash_code_execution_result',
     * } $content
     */
    public static function with(
        BetaBashCodeExecutionToolResultError|array|BetaBashCodeExecutionResultBlock $content,
        string $toolUseID,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['toolUseID'] = $toolUseID;

        return $obj;
    }

    /**
     * @param BetaBashCodeExecutionToolResultError|array{
     *   errorCode: value-of<ErrorCode>, type?: 'bash_code_execution_tool_result_error'
     * }|BetaBashCodeExecutionResultBlock|array{
     *   content: list<BetaBashCodeExecutionOutputBlock>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'bash_code_execution_result',
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
        $obj['toolUseID'] = $toolUseID;

        return $obj;
    }
}
