<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionToolResultErrorShape = array{
 *   errorCode: value-of<BetaCodeExecutionToolResultErrorCode>,
 *   type?: 'code_execution_tool_result_error',
 * }
 */
final class BetaCodeExecutionToolResultError implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionToolResultErrorShape> */
    use SdkModel;

    /** @var 'code_execution_tool_result_error' $type */
    #[Required]
    public string $type = 'code_execution_tool_result_error';

    /** @var value-of<BetaCodeExecutionToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: BetaCodeExecutionToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaCodeExecutionToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultError::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionToolResultError)->withErrorCode(...)
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
     * @param BetaCodeExecutionToolResultErrorCode|value-of<BetaCodeExecutionToolResultErrorCode> $errorCode
     */
    public static function with(
        BetaCodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $obj = new self;

        $obj['errorCode'] = $errorCode;

        return $obj;
    }

    /**
     * @param BetaCodeExecutionToolResultErrorCode|value-of<BetaCodeExecutionToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaCodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $obj = clone $this;
        $obj['errorCode'] = $errorCode;

        return $obj;
    }
}
