<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCitationsDelta\Type;

final class BetaCitationsDelta implements BaseModel
{
    use Model;

    #[Api]
    public BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'citations_delta';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation,
        string $type = 'citations_delta',
    ) {
        $this->citation = $citation;
        $this->type = $type;
    }
}

BetaCitationsDelta::_loadMetadata();
