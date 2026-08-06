<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Cumulative count of server-executed tool invocations, broken down by tool.
 *
 * @phpstan-type BetaManagedAgentsServerToolUsageShape = array{
 *   webFetchRequests?: int|null, webSearchRequests?: int|null
 * }
 */
final class BetaManagedAgentsServerToolUsage implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsServerToolUsageShape> */
    use SdkModel;

    /**
     * Number of server-executed web fetch requests.
     */
    #[Optional('web_fetch_requests')]
    public ?int $webFetchRequests;

    /**
     * Number of server-executed web search requests.
     */
    #[Optional('web_search_requests')]
    public ?int $webSearchRequests;

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
        ?int $webFetchRequests = null,
        ?int $webSearchRequests = null
    ): self {
        $self = new self;

        null !== $webFetchRequests && $self['webFetchRequests'] = $webFetchRequests;
        null !== $webSearchRequests && $self['webSearchRequests'] = $webSearchRequests;

        return $self;
    }

    /**
     * Number of server-executed web fetch requests.
     */
    public function withWebFetchRequests(int $webFetchRequests): self
    {
        $self = clone $this;
        $self['webFetchRequests'] = $webFetchRequests;

        return $self;
    }

    /**
     * Number of server-executed web search requests.
     */
    public function withWebSearchRequests(int $webSearchRequests): self
    {
        $self = clone $this;
        $self['webSearchRequests'] = $webSearchRequests;

        return $self;
    }
}
