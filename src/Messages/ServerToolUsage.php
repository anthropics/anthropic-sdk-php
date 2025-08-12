<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type server_tool_usage_alias = array{webSearchRequests: int}
 */
final class ServerToolUsage implements BaseModel
{
    use ModelTrait;

    /**
     * The number of web search tool requests.
     */
    #[Api('web_search_requests')]
    public int $webSearchRequests;

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
    public static function new(int $webSearchRequests = 0): self
    {
        $obj = new self;

        $obj->webSearchRequests = $webSearchRequests;

        return $obj;
    }

    /**
     * The number of web search tool requests.
     */
    public function setWebSearchRequests(int $webSearchRequests): self
    {
        $this->webSearchRequests = $webSearchRequests;

        return $this;
    }
}
