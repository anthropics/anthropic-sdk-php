<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock\Content
 *
 * @phpstan-type BetaBashCodeExecutionToolResultBlockShape = array{
 *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock|ContentShape,
 *   toolUseID: string,
 *   type: 'bash_code_execution_tool_result',
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
     * @param ContentShape $content
     */
    public static function with(
        BetaBashCodeExecutionToolResultError|array|BetaBashCodeExecutionResultBlock $content,
        string $toolUseID,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param ContentShape $content
     */
    public function withContent(
        BetaBashCodeExecutionToolResultError|array|BetaBashCodeExecutionResultBlock $content,
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
