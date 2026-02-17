<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextEditorCodeExecutionToolResultErrorParamShape = array{
 *   errorCode: TextEditorCodeExecutionToolResultErrorCode|value-of<TextEditorCodeExecutionToolResultErrorCode>,
 *   type: 'text_editor_code_execution_tool_result_error',
 *   errorMessage?: string|null,
 * }
 */
final class TextEditorCodeExecutionToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<TextEditorCodeExecutionToolResultErrorParamShape> */
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

    #[Optional('error_message', nullable: true)]
    public ?string $errorMessage;

    /**
     * `new TextEditorCodeExecutionToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextEditorCodeExecutionToolResultErrorParam::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextEditorCodeExecutionToolResultErrorParam)->withErrorCode(...)
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
        ?string $errorMessage = null,
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        null !== $errorMessage && $self['errorMessage'] = $errorMessage;

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

    /**
     * @param 'text_editor_code_execution_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }
}
