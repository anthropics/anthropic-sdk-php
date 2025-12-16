<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCitationsDelta\Citation;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CitationShape from \Anthropic\Beta\Messages\BetaCitationsDelta\Citation
 *
 * @phpstan-type BetaCitationsDeltaShape = array{
 *   citation: BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation|CitationShape,
 *   type: 'citations_delta',
 * }
 */
final class BetaCitationsDelta implements BaseModel
{
    /** @use SdkModel<BetaCitationsDeltaShape> */
    use SdkModel;

    /** @var 'citations_delta' $type */
    #[Required]
    public string $type = 'citations_delta';

    #[Required(union: Citation::class)]
    public BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation;

    /**
     * `new BetaCitationsDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationsDelta::with(citation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationsDelta)->withCitation(...)
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
     * @param CitationShape $citation
     */
    public static function with(
        BetaCitationCharLocation|array|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation,
    ): self {
        $self = new self;

        $self['citation'] = $citation;

        return $self;
    }

    /**
     * @param CitationShape $citation
     */
    public function withCitation(
        BetaCitationCharLocation|array|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation,
    ): self {
        $self = clone $this;
        $self['citation'] = $citation;

        return $self;
    }
}
