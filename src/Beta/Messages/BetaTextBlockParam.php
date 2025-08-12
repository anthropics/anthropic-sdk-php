<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_text_block_param_alias = array{
 *   text: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
 * }
 */
final class BetaTextBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text';

    #[Api]
    public string $text;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var null|list<BetaCitationCharLocationParam|BetaCitationContentBlockLocationParam|BetaCitationPageLocationParam|BetaCitationSearchResultLocationParam|BetaCitationWebSearchResultLocationParam> $citations
     */
    #[Api(
        type: new ListOf(union: BetaTextCitationParam::class),
        nullable: true,
        optional: true,
    )]
    public ?array $citations;

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
     * @param null|list<BetaCitationCharLocationParam|BetaCitationContentBlockLocationParam|BetaCitationPageLocationParam|BetaCitationSearchResultLocationParam|BetaCitationWebSearchResultLocationParam> $citations
     */
    public static function from(
        string $text,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?array $citations = null,
    ): self {
        $obj = new self;

        $obj->text = $text;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $citations && $obj->citations = $citations;

        return $obj;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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

    /**
     * @param null|list<BetaCitationCharLocationParam|BetaCitationContentBlockLocationParam|BetaCitationPageLocationParam|BetaCitationSearchResultLocationParam|BetaCitationWebSearchResultLocationParam> $citations
     */
    public function setCitations(?array $citations): self
    {
        $this->citations = $citations;

        return $this;
    }
}
