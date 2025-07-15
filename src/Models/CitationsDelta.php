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
    public CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsWebSearchResultLocation $citation;

    #[Api]
    public string $type = 'citations_delta';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsWebSearchResultLocation $citation,
        string $type = 'citations_delta',
    ) {
        $this->citation = $citation;
        $this->type = $type;
    }
}

CitationsDelta::_loadMetadata();
