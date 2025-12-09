<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaServerToolUsageShape = array{
 *   webFetchRequests: int, webSearchRequests: int
 * }
 */
final class BetaServerToolUsage implements BaseModel
{
    /** @use SdkModel<BetaServerToolUsageShape> */
    use SdkModel;

    /**
     * The number of web fetch tool requests.
     */
    #[Required('web_fetch_requests')]
    public int $webFetchRequests;

    /**
     * The number of web search tool requests.
     */
    #[Required('web_search_requests')]
    public int $webSearchRequests;

    /**
     * `new BetaServerToolUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolUsage::with(webFetchRequests: ..., webSearchRequests: ...)
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
        int $webFetchRequests = 0,
        int $webSearchRequests = 0
    ): self {
        $obj = new self;

        $obj['webFetchRequests'] = $webFetchRequests;
        $obj['webSearchRequests'] = $webSearchRequests;

        return $obj;
    }

    /**
     * The number of web fetch tool requests.
     */
    public function withWebFetchRequests(int $webFetchRequests): self
    {
        $obj = clone $this;
        $obj['webFetchRequests'] = $webFetchRequests;

        return $obj;
    }

    /**
     * The number of web search tool requests.
     */
    public function withWebSearchRequests(int $webSearchRequests): self
    {
        $obj = clone $this;
        $obj['webSearchRequests'] = $webSearchRequests;

        return $obj;
    }
}
