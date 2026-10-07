<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type AnalyticsServerToolUseShape = array{webSearchRequests: int}
 */
final class AnalyticsServerToolUse implements BaseModel
{
    /** @use SdkModel<AnalyticsServerToolUseShape> */
    use SdkModel;

    /**
     * The number of web search requests made.
     */
    #[Required('web_search_requests')]
    public int $webSearchRequests;

    /**
     * `new AnalyticsServerToolUse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsServerToolUse::with(webSearchRequests: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsServerToolUse())->withWebSearchRequests(...)
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
    public static function with(int $webSearchRequests): self
    {
        $self = new self;

        $self['webSearchRequests'] = $webSearchRequests;

        return $self;
    }

    /**
     * The number of web search requests made.
     */
    public function withWebSearchRequests(int $webSearchRequests): self
    {
        $self = clone $this;
        $self['webSearchRequests'] = $webSearchRequests;

        return $self;
    }
}
