<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultErrorParam\ErrorCode;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBashCodeExecutionToolResultErrorParamShape = array{
 *   error_code: value-of<ErrorCode>, type: 'bash_code_execution_tool_result_error'
 * }
 */
final class BetaBashCodeExecutionToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'bash_code_execution_tool_result_error' $type */
    #[Required]
    public string $type = 'bash_code_execution_tool_result_error';

    /** @var value-of<ErrorCode> $error_code */
    #[Required(enum: ErrorCode::class)]
    public string $error_code;

    /**
     * `new BetaBashCodeExecutionToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionToolResultErrorParam::with(error_code: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionToolResultErrorParam)->withErrorCode(...)
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
    public static function with(ErrorCode|string $error_code): self
    {
        $obj = new self;

        $obj['error_code'] = $error_code;

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
}
