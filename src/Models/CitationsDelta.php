<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class CitationsDelta implements BaseModel
{
    use Model;

    /**
     * @var CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsWebSearchResultLocation $citation
     */
    #[Api]
    public mixed $citation;

    #[Api]
    public string $type;

    /**
     * @param CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsWebSearchResultLocation $citation
     * @param string                                                                                                  $type
     */
    final public function __construct($citation, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

CitationsDelta::_loadMetadata();
