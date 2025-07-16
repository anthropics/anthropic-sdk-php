<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCitationsDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'citations_delta';

    #[Api]
    public BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation,
    ) {
        $this->citation = $citation;
    }
}

BetaCitationsDelta::__introspect();
