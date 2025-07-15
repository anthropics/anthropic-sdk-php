<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaRequestMCPToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /** @var null|list<BetaTextBlockParam>|string $content */
    #[Api(
        type: new UnionOf(['string', new ListOf(BetaTextBlockParam::class)]),
        optional: true,
    )]
    public mixed $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string                               $toolUseID    `required`
     * @param string                               $type         `required`
     * @param BetaCacheControlEphemeral            $cacheControl
     * @param null|list<BetaTextBlockParam>|string $content
     * @param null|bool                            $isError
     */
    final public function __construct(
        $toolUseID,
        $type,
        $cacheControl = None::NOT_GIVEN,
        $content = None::NOT_GIVEN,
        $isError = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRequestMCPToolResultBlockParam::_loadMetadata();
