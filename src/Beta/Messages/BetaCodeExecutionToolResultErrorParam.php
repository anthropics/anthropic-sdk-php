<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_code_execution_tool_result_error_param_alias = array{
 *   errorCode: BetaCodeExecutionToolResultErrorCode::*, type: string
 * }
 */
final class BetaCodeExecutionToolResultErrorParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'code_execution_tool_result_error';

    /** @var BetaCodeExecutionToolResultErrorCode::* $errorCode */
    #[Api('error_code', enum: BetaCodeExecutionToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaCodeExecutionToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultErrorParam::with(errorCode: ...)
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCodeExecutionToolResultErrorCode::* $errorCode
     */
    public static function with(string $errorCode): self
    {
        $obj = new self;

        $obj->errorCode = $errorCode;

        return $obj;
    }

    /**
     * @param BetaCodeExecutionToolResultErrorCode::* $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $obj = clone $this;
        $obj->errorCode = $errorCode;

        return $obj;
    }
}
