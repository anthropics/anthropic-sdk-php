<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaTextCitationParamShape from \Anthropic\Beta\Messages\BetaTextCitationParam
 *
 * @phpstan-type BetaTextBlockParamShape = array{
 *   text: string,
 *   type: 'text',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   citations?: list<BetaTextCitationParamShape>|null,
 * }
 */
final class BetaTextBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextBlockParamShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required]
    public string $type = 'text';

    #[Required]
    public string $text;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null $citations
     */
    #[Optional(list: BetaTextCitationParam::class, nullable: true)]
    public ?array $citations;

    /**
     * `new BetaTextBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextBlockParam::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextBlockParam)->withText(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     * @param list<BetaTextCitationParamShape>|null $citations
     */
    public static function with(
        string $text,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?array $citations = null,
    ): self {
        $self = new self;

        $self['text'] = $text;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $citations && $self['citations'] = $citations;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param list<BetaTextCitationParamShape>|null $citations
     */
    public function withCitations(?array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }
}
