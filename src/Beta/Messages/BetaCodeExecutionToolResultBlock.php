<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionToolResultBlockShape = array{
 *   content: BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock,
 *   toolUseID: string,
 *   type?: 'code_execution_tool_result',
 * }
 */
final class BetaCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result' $type */
    #[Required]
    public string $type = 'code_execution_tool_result';

    #[Required]
    public BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultBlock::with(content: ..., toolUseID: ...)
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
     *
     * @param BetaCodeExecutionToolResultError|array{
     *   errorCode: value-of<BetaCodeExecutionToolResultErrorCode>,
     *   type?: 'code_execution_tool_result_error',
     * }|BetaCodeExecutionResultBlock|array{
     *   content: list<BetaCodeExecutionOutputBlock>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'code_execution_result',
     * } $content
     */
    public static function with(
        BetaCodeExecutionToolResultError|array|BetaCodeExecutionResultBlock $content,
        string $toolUseID,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param BetaCodeExecutionToolResultError|array{
     *   errorCode: value-of<BetaCodeExecutionToolResultErrorCode>,
     *   type?: 'code_execution_tool_result_error',
     * }|BetaCodeExecutionResultBlock|array{
     *   content: list<BetaCodeExecutionOutputBlock>,
     *   returnCode: int,
     *   stderr: string,
     *   stdout: string,
     *   type?: 'code_execution_result',
     * } $content
     */
    public function withContent(
        BetaCodeExecutionToolResultError|array|BetaCodeExecutionResultBlock $content
    ): self {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }
}
