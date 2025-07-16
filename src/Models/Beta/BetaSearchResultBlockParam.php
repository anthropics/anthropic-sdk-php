<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Models\Beta\BetaSearchResultBlockParam\Type;

final class BetaSearchResultBlockParam implements BaseModel
{
    use Model;

    /** @var list<BetaTextBlockParam> $content */
    #[Api(type: new ListOf(BetaTextBlockParam::class))]
    public array $content;

    #[Api]
    public string $source;

    #[Api]
    public string $title;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?BetaCitationsConfigParam $citations;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaTextBlockParam> $content
     * @param Type::*                  $type
     */
    final public function __construct(
        array $content,
        string $source,
        string $title,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
    ) {
        $this->content = $content;
        $this->source = $source;
        $this->title = $title;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
        $this->citations = $citations;
    }
}

BetaSearchResultBlockParam::_loadMetadata();
