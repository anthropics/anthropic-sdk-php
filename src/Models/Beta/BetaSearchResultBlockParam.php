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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaTextBlockParam> $content
     */
    public static function new(
        array $content,
        string $source,
        string $title,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->source = $source;
        $obj->title = $title;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $citations && $obj->citations = $citations;

        return $obj;
    }

    /**
     * @param list<BetaTextBlockParam> $content
     */
    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    public function setCitations(BetaCitationsConfigParam $citations): self
    {
        $this->citations = $citations;

        return $this;
    }
}
