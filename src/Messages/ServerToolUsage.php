<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ServerToolUsageShape = array{webSearchRequests: int}
 */
final class ServerToolUsage implements BaseModel
{
    /** @use SdkModel<ServerToolUsageShape> */
    use SdkModel;

    /**
     * The number of web search tool requests.
     */
    #[Required('web_search_requests')]
    public int $webSearchRequests;

    /**
     * `new ServerToolUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolUsage::with(webSearchRequests: ...)
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
    public static function with(int $webSearchRequests = 0): self
    {
        $self = new self;

        $self['webSearchRequests'] = $webSearchRequests;

        return $self;
    }

    /**
     * The number of web search tool requests.
     */
    public function withWebSearchRequests(int $webSearchRequests): self
    {
        $self = clone $this;
        $self['webSearchRequests'] = $webSearchRequests;

        return $self;
    }
}
