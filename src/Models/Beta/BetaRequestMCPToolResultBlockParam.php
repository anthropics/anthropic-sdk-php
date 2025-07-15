<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
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
    public null|array|string $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<BetaTextBlockParam>|string $content
     */
    final public function __construct(
        string $toolUseID,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
        null|array|string $content = null,
        ?bool $isError = null,
    ) {
        $this->toolUseID = $toolUseID;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
        $this->content = $content;
        $this->isError = $isError;
    }
}

BetaRequestMCPToolResultBlockParam::_loadMetadata();
