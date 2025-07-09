<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class ServerToolUsage implements BaseModel
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

ServerToolUsage::_loadMetadata();
