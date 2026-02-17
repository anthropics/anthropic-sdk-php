<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Messages\TextEditorCodeExecutionToolResultBlock\Content
 * @phpstan-import-type ContentShape from \Anthropic\Messages\TextEditorCodeExecutionToolResultBlock\Content
 *
 * @phpstan-type TextEditorCodeExecutionToolResultBlockShape = array{
 *   content: ContentShape,
 *   toolUseID: string,
 *   type: 'text_editor_code_execution_tool_result',
 * }
 */
final class TextEditorCodeExecutionToolResultBlock implements BaseModel
{
    /** @use SdkModel<TextEditorCodeExecutionToolResultBlockShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_tool_result' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_tool_result';

    /** @var ContentVariants $content */
    #[Required]
    public TextEditorCodeExecutionToolResultError|TextEditorCodeExecutionViewResultBlock|TextEditorCodeExecutionCreateResultBlock|TextEditorCodeExecutionStrReplaceResultBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new TextEditorCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextEditorCodeExecutionToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextEditorCodeExecutionToolResultBlock)
     *   ->withContent(...)
     *   ->withToolUseID(...)
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
        TextEditorCodeExecutionToolResultError|array|TextEditorCodeExecutionViewResultBlock|TextEditorCodeExecutionCreateResultBlock|TextEditorCodeExecutionStrReplaceResultBlock $content,
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
        TextEditorCodeExecutionToolResultError|array|TextEditorCodeExecutionViewResultBlock|TextEditorCodeExecutionCreateResultBlock|TextEditorCodeExecutionStrReplaceResultBlock $content,
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

    /**
     * @param 'text_editor_code_execution_tool_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
