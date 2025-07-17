<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class TextBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text';

    /**
     * @var list<
     *   CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation
     * >|null $citations
     */
    #[Api(
        type: new ListOf(
            union: new UnionOf(
                [
                    CitationCharLocation::class,
                    CitationPageLocation::class,
                    CitationContentBlockLocation::class,
                    CitationsWebSearchResultLocation::class,
                ],
            ),
        ),
        nullable: true,
    )]
    public ?array $citations;

    #[Api]
    public string $text;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation
     * >|null $citations
     */
    final public function __construct(?array $citations, string $text)
    {
        $this->citations = $citations;
        $this->text = $text;

        self::_introspect();
    }
}
