<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type server_tool_usage_alias = array{webSearchRequests: int}
 */
final class ServerToolUsage implements BaseModel
{
    use Model;

    /**
     * The number of web search tool requests.
     */
    #[Api('web_search_requests')]
    public int $webSearchRequests;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(int $webSearchRequests = 0)
    {
        self::introspect();

        $this->webSearchRequests = $webSearchRequests;
    }
}
