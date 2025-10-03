<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorParam\ErrorCode;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_text_editor_code_execution_tool_result_error_param = array{
 *   errorCode: value-of<ErrorCode>, type: string, errorMessage?: string|null
 * }
 */
final class BetaTextEditorCodeExecutionToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<beta_text_editor_code_execution_tool_result_error_param> */
    use SdkModel;

    #[Api]
    public string $type = 'text_editor_code_execution_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Api('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    #[Api('error_message', nullable: true, optional: true)]
    public ?string $errorMessage;

    /**
     * `new BetaTextEditorCodeExecutionToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionToolResultErrorParam::with(errorCode: ...)
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
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public static function with(
        ErrorCode|string $errorCode,
        ?string $errorMessage = null
    ): self {
        $obj = new self;

        $obj['errorCode'] = $errorCode;

        null !== $errorMessage && $obj->errorMessage = $errorMessage;

        return $obj;
    }

    /**
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public function withErrorCode(ErrorCode|string $errorCode): self
    {
        $obj = clone $this;
        $obj['errorCode'] = $errorCode;

        return $obj;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $obj = clone $this;
        $obj->errorMessage = $errorMessage;

        return $obj;
    }
}
