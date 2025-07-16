<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ServerToolUsage implements BaseModel
{
    use Model;

    #[Api('web_search_requests')]
    public int $webSearchRequests = 0;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $webSearchRequests = 0)
    {
        $this->webSearchRequests = $webSearchRequests;
    }
}

ServerToolUsage::__introspect();
