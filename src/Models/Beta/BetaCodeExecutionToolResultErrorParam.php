<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

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
    public static function new(string $errorCode): self
    {
        $obj = new self;

        $obj->errorCode = $errorCode;

        return $obj;
    }

    /**
     * @param BetaCodeExecutionToolResultErrorCode::* $errorCode
     */
    public function setErrorCode(string $errorCode): self
    {
        $this->errorCode = $errorCode;

        return $this;
    }
}
