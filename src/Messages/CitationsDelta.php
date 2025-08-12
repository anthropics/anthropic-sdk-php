<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CitationsDelta\Citation;

/**
 * @phpstan-type citations_delta_alias = array{
 *   citation: CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation,
 *   type: string,
 * }
 */
final class CitationsDelta implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'citations_delta';

    #[Api(union: Citation::class)]
    public CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsSearchResultLocation|CitationsWebSearchResultLocation $citation;

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
    public static function from(
        CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsSearchResultLocation|CitationsWebSearchResultLocation $citation,
    ): self {
        $obj = new self;

        $obj->citation = $citation;

        return $obj;
    }

    public function setCitation(
        CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsSearchResultLocation|CitationsWebSearchResultLocation $citation,
    ): self {
        $this->citation = $citation;

        return $this;
    }
}
