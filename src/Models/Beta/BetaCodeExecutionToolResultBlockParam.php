<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCodeExecutionToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'code_execution_tool_result';

    #[Api]
    public BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content,
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        $this->content = $content;
        $this->toolUseID = $toolUseID;
        $this->cacheControl = $cacheControl;
    }
}

BetaCodeExecutionToolResultBlockParam::_loadMetadata();
