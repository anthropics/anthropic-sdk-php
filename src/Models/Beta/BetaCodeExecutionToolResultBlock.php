<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCodeExecutionToolResultBlock\Type;

final class BetaCodeExecutionToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'code_execution_tool_result';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content,
        string $toolUseID,
        string $type = 'code_execution_tool_result',
    ) {
        $this->content = $content;
        $this->toolUseID = $toolUseID;
        $this->type = $type;
    }
}

BetaCodeExecutionToolResultBlock::_loadMetadata();
