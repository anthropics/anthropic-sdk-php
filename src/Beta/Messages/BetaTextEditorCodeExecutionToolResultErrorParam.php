<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorParam\ErrorCode;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionToolResultErrorParamShape = array{
 *   error_code: value-of<ErrorCode>,
 *   type: 'text_editor_code_execution_tool_result_error',
 *   error_message?: string|null,
 * }
 */
final class BetaTextEditorCodeExecutionToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_tool_result_error' $type */
    #[Api]
    public string $type = 'text_editor_code_execution_tool_result_error';

    /** @var value-of<ErrorCode> $error_code */
    #[Api(enum: ErrorCode::class)]
    public string $error_code;

    #[Api(nullable: true, optional: true)]
    public ?string $error_message;

    /**
     * `new BetaTextEditorCodeExecutionToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionToolResultErrorParam::with(error_code: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionToolResultErrorParam)->withErrorCode(...)
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
     * @param ErrorCode|value-of<ErrorCode> $error_code
     */
    public static function with(
        ErrorCode|string $error_code,
        ?string $error_message = null
    ): self {
        $obj = new self;

        $obj['error_code'] = $error_code;

        null !== $error_message && $obj['error_message'] = $error_message;

        return $obj;
    }

    /**
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public function withErrorCode(ErrorCode|string $errorCode): self
    {
        $obj = clone $this;
        $obj['error_code'] = $errorCode;

        return $obj;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $obj = clone $this;
        $obj['error_message'] = $errorMessage;

        return $obj;
    }
}
