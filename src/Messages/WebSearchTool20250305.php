<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\WebSearchTool20250305\UserLocation;

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
    use ModelTrait;

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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param null|list<string> $allowedDomains
     * @param null|list<string> $blockedDomains
     */
    public static function from(
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?CacheControlEphemeral $cacheControl = null,
        ?int $maxUses = null,
        ?UserLocation $userLocation = null,
    ): self {
        $obj = new self;

        null !== $allowedDomains && $obj->allowedDomains = $allowedDomains;
        null !== $blockedDomains && $obj->blockedDomains = $blockedDomains;
        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $maxUses && $obj->maxUses = $maxUses;
        null !== $userLocation && $obj->userLocation = $userLocation;

        return $obj;
    }

    /**
     * If provided, only these domains will be included in results. Cannot be used alongside `blocked_domains`.
     *
     * @param null|list<string> $allowedDomains
     */
    public function setAllowedDomains(?array $allowedDomains): self
    {
        $this->allowedDomains = $allowedDomains;

        return $this;
    }

    /**
     * If provided, these domains will never appear in results. Cannot be used alongside `allowed_domains`.
     *
     * @param null|list<string> $blockedDomains
     */
    public function setBlockedDomains(?array $blockedDomains): self
    {
        $this->blockedDomains = $blockedDomains;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function setMaxUses(?int $maxUses): self
    {
        $this->maxUses = $maxUses;

        return $this;
    }

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     */
    public function setUserLocation(?UserLocation $userLocation): self
    {
        $this->userLocation = $userLocation;

        return $this;
    }
}
