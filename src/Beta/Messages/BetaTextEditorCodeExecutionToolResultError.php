<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultError\ErrorCode;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextEditorCodeExecutionToolResultErrorShape = array{
 *   errorCode: value-of<ErrorCode>, errorMessage: string|null, type: string
 * }
 */
final class BetaTextEditorCodeExecutionToolResultError implements BaseModel
{
    /** @use SdkModel<BetaTextEditorCodeExecutionToolResultErrorShape> */
    use SdkModel;

    #[Api]
    public string $type = 'text_editor_code_execution_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Api('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    #[Api('error_message')]
    public ?string $errorMessage;

    /**
     * `new BetaTextEditorCodeExecutionToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextEditorCodeExecutionToolResultError::with(
     *   errorCode: ..., errorMessage: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextEditorCodeExecutionToolResultError)
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
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public static function with(
        ErrorCode|string $errorCode,
        ?string $errorMessage
    ): self {
        $obj = new self;

        $obj['errorCode'] = $errorCode;
        $obj->errorMessage = $errorMessage;

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
