<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;

class BetaSearchResultBlockParam implements BaseModel
{
    use Model;

    /**
     * @var list<BetaTextBlockParam> $content
     */
    #[Api(type: new ListOf(BetaTextBlockParam::class))]
    public array $content;

    #[Api]
    public string $source;

    #[Api]
    public string $title;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public BetaCitationsConfigParam $citations;

    /**
     * @param list<BetaTextBlockParam>  $content
     * @param BetaCacheControlEphemeral $cacheControl
     * @param BetaCitationsConfigParam  $citations
     */
    final public function __construct(
        array $content,
        string $source,
        string $title,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
        BetaCitationsConfigParam|None $citations = None::NOT_SET
    ) {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

BetaSearchResultBlockParam::_loadMetadata();
