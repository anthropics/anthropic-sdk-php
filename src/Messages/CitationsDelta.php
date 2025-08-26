<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CitationsDelta\Citation;

final class CitationsDelta implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'citations_delta';

    #[Api(union: Citation::class)]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation,
    ): self {
        $obj = new self;

        $obj->citation = $citation;

        return $obj;
    }

    public function withCitation(
        CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation,
    ): self {
        $obj = clone $this;
        $obj->citation = $citation;

        return $obj;
    }
}
