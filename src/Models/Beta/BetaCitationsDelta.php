<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaCitationsDelta implements BaseModel
{
    use Model;

    /**
     * @var BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation
     */
    #[Api]
    public mixed $citation;

    #[Api]
    public string $type;

    /**
     * @param BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation $citation
     * @param string                                                                                                                                                   $type
     */
    final public function __construct($citation, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCitationsDelta::_loadMetadata();
