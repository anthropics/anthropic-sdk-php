<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CitationsDelta\Citation;

/**
 * @phpstan-import-type CitationShape from \Anthropic\Messages\CitationsDelta\Citation
 *
 * @phpstan-type CitationsDeltaShape = array{
 *   citation: CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation|CitationShape,
 *   type: 'citations_delta',
 * }
 */
final class CitationsDelta implements BaseModel
{
    /** @use SdkModel<CitationsDeltaShape> */
    use SdkModel;

    /** @var 'citations_delta' $type */
    #[Required]
    public string $type = 'citations_delta';

    #[Required(union: Citation::class)]
    public CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation;

    /**
     * `new CitationsDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationsDelta::with(citation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationsDelta)->withCitation(...)
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
        CitationCharLocation|array|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation,
    ): self {
        $self = new self;

        $self['citation'] = $citation;

        return $self;
    }

    /**
     * @param CitationShape $citation
     */
    public function withCitation(
        CitationCharLocation|array|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation,
    ): self {
        $self = clone $this;
        $self['citation'] = $citation;

        return $self;
    }
}
