<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaServerToolUsage implements BaseModel
{
    use Model;

    #[Api('web_search_requests')]
    public int $webSearchRequests;

    /** @param int $webSearchRequests */
    final public function __construct($webSearchRequests)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaServerToolUsage::_loadMetadata();
