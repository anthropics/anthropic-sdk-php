<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCodeExecutionToolResultError\Type;

final class BetaCodeExecutionToolResultError implements BaseModel
{
    use Model;

    /** @var BetaCodeExecutionToolResultErrorCode::* $errorCode */
    #[Api('error_code')]
    public string $errorCode;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'code_execution_tool_result_error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaCodeExecutionToolResultErrorCode::* $errorCode
     * @param Type::*                                 $type
     */
    final public function __construct(
        string $errorCode,
        string $type = 'code_execution_tool_result_error'
    ) {
        $this->errorCode = $errorCode;
        $this->type = $type;
    }
}

BetaCodeExecutionToolResultError::_loadMetadata();
