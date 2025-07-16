<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class CitationsDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'citations_delta';

    #[Api]
    public CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsWebSearchResultLocation $citation;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsWebSearchResultLocation $citation,
    ) {
        $this->citation = $citation;
    }
}

CitationsDelta::_loadMetadata();
