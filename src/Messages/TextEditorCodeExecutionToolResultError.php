<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextEditorCodeExecutionToolResultErrorShape = array{
 *   errorCode: TextEditorCodeExecutionToolResultErrorCode|value-of<TextEditorCodeExecutionToolResultErrorCode>,
 *   errorMessage: string|null,
 *   type: 'text_editor_code_execution_tool_result_error',
 * }
 */
final class TextEditorCodeExecutionToolResultError implements BaseModel
{
    /** @use SdkModel<TextEditorCodeExecutionToolResultErrorShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_tool_result_error' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_tool_result_error';

    /** @var value-of<TextEditorCodeExecutionToolResultErrorCode> $errorCode */
    #[Required(
        'error_code',
        enum: TextEditorCodeExecutionToolResultErrorCode::class
    )]
    public string $errorCode;

    #[Required('error_message')]
    public ?string $errorMessage;

    /**
     * `new TextEditorCodeExecutionToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextEditorCodeExecutionToolResultError::with(errorCode: ..., errorMessage: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextEditorCodeExecutionToolResultError)
     *   ->withErrorCode(...)
     *   ->withErrorMessage(...)
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
     * @param TextEditorCodeExecutionToolResultErrorCode|value-of<TextEditorCodeExecutionToolResultErrorCode> $errorCode
     */
    public static function with(
        TextEditorCodeExecutionToolResultErrorCode|string $errorCode,
        ?string $errorMessage,
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    /**
     * @param TextEditorCodeExecutionToolResultErrorCode|value-of<TextEditorCodeExecutionToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        TextEditorCodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    /**
     * @param 'text_editor_code_execution_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
