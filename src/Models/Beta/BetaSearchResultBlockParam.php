<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_search_result_block_param_alias = array{
 *   content: list<BetaTextBlockParam>,
 *   source: string,
 *   title: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   citations?: BetaCitationsConfigParam,
 * }
 */
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

    /**
     * Create a cache control breakpoint at this content block.
     */
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
        self::introspect();
        $this->unsetOptionalProperties();

        $this->content = $content;
        $this->source = $source;
        $this->title = $title;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $citations && $this->citations = $citations;
    }
}
