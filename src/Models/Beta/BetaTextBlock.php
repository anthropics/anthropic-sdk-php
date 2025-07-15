<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaTextBlock implements BaseModel
{
    use Model;

    /**
     * @var list<
     *   BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation
     * >|null $citations
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(
                    new UnionOf(
                        [
                            BetaCitationCharLocation::class,
                            BetaCitationPageLocation::class,
                            BetaCitationContentBlockLocation::class,
                            BetaCitationsWebSearchResultLocation::class,
                            BetaCitationSearchResultLocation::class,
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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<
     *   BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation
     * >|null $citations `required`
     * @param string $text `required`
     * @param string $type `required`
     */
    final public function __construct($citations, $text, $type = 'text')
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaTextBlock::_loadMetadata();
