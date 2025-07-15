<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class TextBlock implements BaseModel
{
    use Model;

    /**
     * @var list<
     *   CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation
     * >|null $citations
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(
                    new UnionOf(
                        [
                            CitationCharLocation::class,
                            CitationPageLocation::class,
                            CitationContentBlockLocation::class,
                            CitationsWebSearchResultLocation::class,
                        ],
                    ),
                ),
                'null',
            ],
        ),
    )]
    public ?array $citations;

    #[Api]
    public string $text;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<
     *   CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation
     * >|null $citations `required`
     * @param string $text `required`
     * @param string $type `required`
     */
    final public function __construct($citations, $text, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

TextBlock::_loadMetadata();
