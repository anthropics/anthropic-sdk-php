<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CodeExecutionToolResultErrorShape = array{
 *   errorCode: CodeExecutionToolResultErrorCode|value-of<CodeExecutionToolResultErrorCode>,
 *   type: 'code_execution_tool_result_error',
 * }
 */
final class CodeExecutionToolResultError implements BaseModel
{
    /** @use SdkModel<CodeExecutionToolResultErrorShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result_error' $type */
    #[Required]
    public string $type = 'code_execution_tool_result_error';

    /** @var value-of<CodeExecutionToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: CodeExecutionToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new CodeExecutionToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CodeExecutionToolResultError::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CodeExecutionToolResultError)->withErrorCode(...)
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
     * @param CodeExecutionToolResultErrorCode|value-of<CodeExecutionToolResultErrorCode> $errorCode
     */
    public static function with(
        CodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param CodeExecutionToolResultErrorCode|value-of<CodeExecutionToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        CodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param 'code_execution_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
