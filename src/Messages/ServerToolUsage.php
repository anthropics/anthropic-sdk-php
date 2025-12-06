<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ServerToolUsageShape = array{web_search_requests: int}
 */
final class ServerToolUsage implements BaseModel
{
    /** @use SdkModel<ServerToolUsageShape> */
    use SdkModel;

    /**
     * The number of web search tool requests.
     */
    #[Api]
    public int $web_search_requests;

    /**
     * `new ServerToolUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolUsage::with(web_search_requests: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServerToolUsage)->withWebSearchRequests(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(int $web_search_requests = 0): self
    {
        $obj = new self;

        $obj['web_search_requests'] = $web_search_requests;

        return $obj;
    }

    /**
     * The number of web search tool requests.
     */
    public function withWebSearchRequests(int $webSearchRequests): self
    {
        $obj = clone $this;
        $obj['web_search_requests'] = $webSearchRequests;

        return $obj;
    }
}
