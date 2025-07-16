<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCodeExecutionToolResultError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'code_execution_tool_result_error';

    /** @var BetaCodeExecutionToolResultErrorCode::* $errorCode */
    #[Api('error_code')]
    public string $errorCode;

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaCodeExecutionToolResultErrorCode::* $errorCode
     */
    final public function __construct(string $errorCode)
    {
        $this->errorCode = $errorCode;

        self::_introspect();
    }
}
