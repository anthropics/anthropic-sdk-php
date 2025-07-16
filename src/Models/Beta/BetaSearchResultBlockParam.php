<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;

final class BetaSearchResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'search_result';

    /** @var list<BetaTextBlockParam> $content */
    #[Api(type: new ListOf(BetaTextBlockParam::class))]
    public array $content;

    #[Api]
    public string $source;

    #[Api]
    public string $title;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?BetaCitationsConfigParam $citations;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaTextBlockParam> $content
     */
    final public function __construct(
        array $content,
        string $source,
        string $title,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
    ) {
        $this->content = $content;
        $this->source = $source;
        $this->title = $title;
        $this->cacheControl = $cacheControl;
        $this->citations = $citations;
    }
}

BetaSearchResultBlockParam::__introspect();
