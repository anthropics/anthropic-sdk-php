<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCodeExecutionToolResultBlockParam\Type;

final class BetaCodeExecutionToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content,
        string $toolUseID,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        $this->content = $content;
        $this->toolUseID = $toolUseID;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
    }
}

BetaCodeExecutionToolResultBlockParam::_loadMetadata();
