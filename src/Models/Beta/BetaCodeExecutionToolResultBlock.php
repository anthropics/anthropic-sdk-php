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
    public string $type = 'code_execution_tool_result';

    #[Api]
    public BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content,
        string $toolUseID,
    ) {
        self::introspect();

        $this->content = $content;
        $this->toolUseID = $toolUseID;
    }
}
