<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaTextBlock\Type;

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

    /** @var Type::* $type */
    #[Api]
    public string $type = 'text';

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation
     * >|null $citations
     * @param Type::* $type
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

BetaTextBlock::_loadMetadata();
