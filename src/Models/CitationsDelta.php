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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param CitationCharLocation|CitationContentBlockLocation|CitationPageLocation|CitationsWebSearchResultLocation $citation `required`
     * @param string                                                                                                  $type     `required`
     */
    final public function __construct($citation, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

CitationsDelta::_loadMetadata();
