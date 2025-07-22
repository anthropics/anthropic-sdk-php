<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\WebSearchTool20250305\UserLocation;

/**
 * @phpstan-type web_search_tool20250305_alias = array{
 *   name: string,
 *   type: string,
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: CacheControlEphemeral,
 *   maxUses?: int|null,
 *   userLocation?: UserLocation|null,
 * }
 */
final class WebSearchTool20250305 implements BaseModel
{
    use Model;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Api]
    public string $name = 'web_search';

    #[Api]
    public string $type = 'web_search_20250305';

    /**
     * If provided, only these domains will be included in results. Cannot be used alongside `blocked_domains`.
     *
     * @var null|list<string> $allowedDomains
     */
    #[Api(
        'allowed_domains',
        type: new ListOf('string'),
        nullable: true,
        optional: true,
    )]
    public ?array $allowedDomains;

    /**
     * If provided, these domains will never appear in results. Cannot be used alongside `allowed_domains`.
     *
     * @var null|list<string> $blockedDomains
     */
    #[Api(
        'blocked_domains',
        type: new ListOf('string'),
        nullable: true,
        optional: true,
    )]
    public ?array $blockedDomains;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Api('max_uses', optional: true)]
    public ?int $maxUses;

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     */
    #[Api('user_location', optional: true)]
    public ?UserLocation $userLocation;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string> $allowedDomains
     * @param null|list<string> $blockedDomains
     */
    final public function __construct(
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?CacheControlEphemeral $cacheControl = null,
        ?int $maxUses = null,
        ?UserLocation $userLocation = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $allowedDomains && $this->allowedDomains = $allowedDomains;
        null !== $blockedDomains && $this->blockedDomains = $blockedDomains;
        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $maxUses && $this->maxUses = $maxUses;
        null !== $userLocation && $this->userLocation = $userLocation;
    }
}
