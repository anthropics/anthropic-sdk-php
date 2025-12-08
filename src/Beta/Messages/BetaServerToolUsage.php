<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaServerToolUsageShape = array{
 *   web_fetch_requests: int, web_search_requests: int
 * }
 */
final class BetaServerToolUsage implements BaseModel
{
    /** @use SdkModel<BetaServerToolUsageShape> */
    use SdkModel;

    /**
     * The number of web fetch tool requests.
     */
    #[Required]
    public int $web_fetch_requests;

    /**
     * The number of web search tool requests.
     */
    #[Required]
    public int $web_search_requests;

    /**
     * `new BetaServerToolUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolUsage::with(web_fetch_requests: ..., web_search_requests: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServerToolUsage)->withWebFetchRequests(...)->withWebSearchRequests(...)
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
    public static function with(
        int $web_fetch_requests = 0,
        int $web_search_requests = 0
    ): self {
        $obj = new self;

        $obj['web_fetch_requests'] = $web_fetch_requests;
        $obj['web_search_requests'] = $web_search_requests;

        return $obj;
    }

    /**
     * The number of web fetch tool requests.
     */
    public function withWebFetchRequests(int $webFetchRequests): self
    {
        $obj = clone $this;
        $obj['web_fetch_requests'] = $webFetchRequests;

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
