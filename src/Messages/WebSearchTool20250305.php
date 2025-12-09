<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\WebSearchTool20250305\UserLocation;

/**
 * @phpstan-type WebSearchTool20250305Shape = array{
 *   name?: 'web_search',
 *   type?: 'web_search_20250305',
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: CacheControlEphemeral|null,
 *   maxUses?: int|null,
 *   userLocation?: UserLocation|null,
 * }
 */
final class WebSearchTool20250305 implements BaseModel
{
    /** @use SdkModel<WebSearchTool20250305Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'web_search' $name
     */
    #[Required]
    public string $name = 'web_search';

    /** @var 'web_search_20250305' $type */
    #[Required]
    public string $type = 'web_search_20250305';

    /**
     * If provided, only these domains will be included in results. Cannot be used alongside `blocked_domains`.
     *
     * @var list<string>|null $allowedDomains
     */
    #[Optional('allowed_domains', list: 'string', nullable: true)]
    public ?array $allowedDomains;

    /**
     * If provided, these domains will never appear in results. Cannot be used alongside `allowed_domains`.
     *
     * @var list<string>|null $blockedDomains
     */
    #[Optional('blocked_domains', list: 'string', nullable: true)]
    public ?array $blockedDomains;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Optional('max_uses', nullable: true)]
    public ?int $maxUses;

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     */
    #[Optional('user_location', nullable: true)]
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
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param UserLocation|array{
     *   type?: 'approximate',
     *   city?: string|null,
     *   country?: string|null,
     *   region?: string|null,
     *   timezone?: string|null,
     * }|null $userLocation
     */
    public static function with(
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        CacheControlEphemeral|array|null $cacheControl = null,
        ?int $maxUses = null,
        UserLocation|array|null $userLocation = null,
    ): self {
        $obj = new self;

        null !== $allowedDomains && $obj['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $obj['blockedDomains'] = $blockedDomains;
        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;
        null !== $maxUses && $obj['maxUses'] = $maxUses;
        null !== $userLocation && $obj['userLocation'] = $userLocation;

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
        $obj['allowedDomains'] = $allowedDomains;

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
        $obj['blockedDomains'] = $blockedDomains;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $obj = clone $this;
        $obj['maxUses'] = $maxUses;

        return $obj;
    }

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     *
     * @param UserLocation|array{
     *   type?: 'approximate',
     *   city?: string|null,
     *   country?: string|null,
     *   region?: string|null,
     *   timezone?: string|null,
     * }|null $userLocation
     */
    public function withUserLocation(
        UserLocation|array|null $userLocation
    ): self {
        $obj = clone $this;
        $obj['userLocation'] = $userLocation;

        return $obj;
    }
}
