<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorParam\ErrorCode;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionToolResultErrorParamShape = array{
 *   errorCode: value-of<ErrorCode>,
 *   type?: 'text_editor_code_execution_tool_result_error',
 *   errorMessage?: string|null,
 * }
 */
final class BetaTextEditorCodeExecutionToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'text_editor_code_execution_tool_result_error' $type */
    #[Required]
    public string $type = 'text_editor_code_execution_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Required('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    #[Optional('error_message', nullable: true)]
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

        null !== $errorMessage && $obj['errorMessage'] = $errorMessage;

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
        $obj['errorMessage'] = $errorMessage;

        return $obj;
    }
}
