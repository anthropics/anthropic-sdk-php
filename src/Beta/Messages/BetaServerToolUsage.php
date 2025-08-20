<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_server_tool_usage_alias = array{webSearchRequests: int}
 */
final class BetaServerToolUsage implements BaseModel
{
    use SdkModel;

    /**
     * The number of web search tool requests.
     */
    #[Api('web_search_requests')]
    public int $webSearchRequests;

    /**
     * `new BetaServerToolUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolUsage::with(webSearchRequests: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServerToolUsage)->withWebSearchRequests(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(int $webSearchRequests = 0): self
    {
        $obj = new self;

        $obj->webSearchRequests = $webSearchRequests;

        return $obj;
    }

    /**
     * The number of web search tool requests.
     */
    public function withWebSearchRequests(int $webSearchRequests): self
    {
        $obj = clone $this;
        $obj->webSearchRequests = $webSearchRequests;

        return $obj;
    }
}
