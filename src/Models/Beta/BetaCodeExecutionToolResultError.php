<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_code_execution_tool_result_error_alias = array{
 *   errorCode: BetaCodeExecutionToolResultErrorCode::*, type: string
 * }
 */
final class BetaCodeExecutionToolResultError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'code_execution_tool_result_error';

    /** @var BetaCodeExecutionToolResultErrorCode::* $errorCode */
    #[Api('error_code', enum: BetaCodeExecutionToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaCodeExecutionToolResultErrorCode::* $errorCode
     */
    final public function __construct(string $errorCode)
    {
        self::introspect();

        $this->errorCode = $errorCode;
    }
}
