<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCodeExecutionToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type = 'code_execution_tool_result';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content   `required`
     * @param string                                                        $toolUseID `required`
     * @param string                                                        $type      `required`
     */
    final public function __construct(
        $content,
        $toolUseID,
        $type = 'code_execution_tool_result'
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCodeExecutionToolResultBlock::_loadMetadata();
