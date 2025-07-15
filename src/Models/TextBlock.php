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
    public string $type = 'text';

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation
     * >|null $citations
     */
    final public function __construct(
        ?array $citations,
        string $text,
        string $type = 'text'
    ) {
        $this->citations = $citations;
        $this->text = $text;
        $this->type = $type;
    }
}

TextBlock::_loadMetadata();
