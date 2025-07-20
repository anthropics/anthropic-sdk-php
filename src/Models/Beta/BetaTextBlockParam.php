<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_text_block_param_alias = array{
 *   text: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   citations?: list<
 *     BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
 *   >|null,
 * }
 */
final class BetaTextBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text';

    #[Api]
    public string $text;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var list<
     *   BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
     * >|null $citations
     */
    #[Api(
        type: new ListOf(union: BetaTextCitationParam::class),
        nullable: true,
        optional: true,
    )]
    public ?array $citations;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
     * >|null $citations
     */
    final public function __construct(
        string $text,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?array $citations = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->text = $text;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $citations && $this->citations = $citations;
    }
}
