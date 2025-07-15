<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

final class BetaCodeExecutionToolResultBlockParam implements BaseModel
{
    use Model;

    /**
     * @var BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content
     */
    #[Api]
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaCodeExecutionResultBlockParam|BetaCodeExecutionToolResultErrorParam $content      `required`
     * @param string                                                                  $toolUseID    `required`
     * @param string                                                                  $type         `required`
     * @param BetaCacheControlEphemeral                                               $cacheControl
     */
    final public function __construct(
        $content,
        $toolUseID,
        $type,
        $cacheControl = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCodeExecutionToolResultBlockParam::_loadMetadata();
