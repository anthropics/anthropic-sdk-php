<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaCodeExecutionToolResultBlock implements BaseModel
{
    use Model;

    /**
     * @var BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content
     */
    #[Api]
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    /**
     * @param BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content
     * @param string                                                        $toolUseID
     * @param string                                                        $type
     */
    final public function __construct($content, $toolUseID, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCodeExecutionToolResultBlock::_loadMetadata();
