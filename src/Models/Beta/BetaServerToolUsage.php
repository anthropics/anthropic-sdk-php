<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaServerToolUsage implements BaseModel
{
    use Model;

    #[Api('web_search_requests')]
    public int $webSearchRequests = 0;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $webSearchRequests = 0)
    {
        self::introspect();

        $this->webSearchRequests = $webSearchRequests;
    }
}
