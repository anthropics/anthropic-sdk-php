<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaWebSearchTool20250305\UserLocation;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_search_tool20250305 = array{
 *   name: string,
 *   type: string,
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   maxUses?: int|null,
 *   userLocation?: UserLocation|null,
 * }
 */
final class BetaWebSearchTool20250305 implements BaseModel
{
    /** @use SdkModel<beta_web_search_tool20250305> */
    use SdkModel;

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
     * @var list<string>|null $allowedDomains
     */
    #[Api('allowed_domains', list: 'string', nullable: true, optional: true)]
    public ?array $allowedDomains;

    /**
     * If provided, these domains will never appear in results. Cannot be used alongside `allowed_domains`.
     *
     * @var list<string>|null $blockedDomains
     */
    #[Api('blocked_domains', list: 'string', nullable: true, optional: true)]
    public ?array $blockedDomains;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Api('max_uses', nullable: true, optional: true)]
    public ?int $maxUses;

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     */
    #[Api('user_location', nullable: true, optional: true)]
    public ?UserLocation $userLocation;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     */
    public static function with(
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?BetaCacheControlEphemeral $cacheControl = null,
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
     * @param list<string>|null $allowedDomains
     */
    public function withAllowedDomains(?array $allowedDomains): self
    {
        $obj = clone $this;
        $obj->allowedDomains = $allowedDomains;

        return $obj;
    }

    /**
     * If provided, these domains will never appear in results. Cannot be used alongside `allowed_domains`.
     *
     * @param list<string>|null $blockedDomains
     */
    public function withBlockedDomains(?array $blockedDomains): self
    {
        $obj = clone $this;
        $obj->blockedDomains = $blockedDomains;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $obj = clone $this;
        $obj->maxUses = $maxUses;

        return $obj;
    }

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     */
    public function withUserLocation(?UserLocation $userLocation): self
    {
        $obj = clone $this;
        $obj->userLocation = $userLocation;

        return $obj;
    }
}
