<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionToolResultErrorParamShape = array{
 *   error_code: value-of<BetaCodeExecutionToolResultErrorCode>,
 *   type: 'code_execution_tool_result_error',
 * }
 */
final class BetaCodeExecutionToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result_error' $type */
    #[Required]
    public string $type = 'code_execution_tool_result_error';

    /** @var value-of<BetaCodeExecutionToolResultErrorCode> $error_code */
    #[Required(enum: BetaCodeExecutionToolResultErrorCode::class)]
    public string $error_code;

    /**
     * `new BetaCodeExecutionToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultErrorParam::with(error_code: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionToolResultErrorParam)->withErrorCode(...)
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
     * @param BetaCodeExecutionToolResultErrorCode|value-of<BetaCodeExecutionToolResultErrorCode> $error_code
     */
    public static function with(
        BetaCodeExecutionToolResultErrorCode|string $error_code
    ): self {
        $obj = new self;

        $obj['error_code'] = $error_code;

        return $obj;
    }

    /**
     * @param BetaCodeExecutionToolResultErrorCode|value-of<BetaCodeExecutionToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaCodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $obj = clone $this;
        $obj['error_code'] = $errorCode;

        return $obj;
    }
}
