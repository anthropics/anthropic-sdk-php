<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305\AllowedCaller;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305\UserLocation;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchTool20250305Shape = array{
 *   name: 'web_search',
 *   type: 'web_search_20250305',
 *   allowed_callers?: list<value-of<AllowedCaller>>|null,
 *   allowed_domains?: list<string>|null,
 *   blocked_domains?: list<string>|null,
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   defer_loading?: bool|null,
 *   max_uses?: int|null,
 *   strict?: bool|null,
 *   user_location?: UserLocation|null,
 * }
 */
final class BetaWebSearchTool20250305 implements BaseModel
{
    /** @use SdkModel<BetaWebSearchTool20250305Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'web_search' $name
     */
    #[Api]
    public string $name = 'web_search';

    /** @var 'web_search_20250305' $type */
    #[Api]
    public string $type = 'web_search_20250305';

    /** @var list<value-of<AllowedCaller>>|null $allowed_callers */
    #[Api(list: AllowedCaller::class, optional: true)]
    public ?array $allowed_callers;

    /**
     * If provided, only these domains will be included in results. Cannot be used alongside `blocked_domains`.
     *
     * @var list<string>|null $allowed_domains
     */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $allowed_domains;

    /**
     * If provided, these domains will never appear in results. Cannot be used alongside `allowed_domains`.
     *
     * @var list<string>|null $blocked_domains
     */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $blocked_domains;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Api(optional: true)]
    public ?bool $defer_loading;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Api(nullable: true, optional: true)]
    public ?int $max_uses;

    #[Api(optional: true)]
    public ?bool $strict;

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     */
    #[Api(nullable: true, optional: true)]
    public ?UserLocation $user_location;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowed_callers
     * @param list<string>|null $allowed_domains
     * @param list<string>|null $blocked_domains
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param UserLocation|array{
     *   type: 'approximate',
     *   city?: string|null,
     *   country?: string|null,
     *   region?: string|null,
     *   timezone?: string|null,
     * }|null $user_location
     */
    public static function with(
        ?array $allowed_callers = null,
        ?array $allowed_domains = null,
        ?array $blocked_domains = null,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        ?bool $defer_loading = null,
        ?int $max_uses = null,
        ?bool $strict = null,
        UserLocation|array|null $user_location = null,
    ): self {
        $obj = new self;

        null !== $allowed_callers && $obj['allowed_callers'] = $allowed_callers;
        null !== $allowed_domains && $obj['allowed_domains'] = $allowed_domains;
        null !== $blocked_domains && $obj['blocked_domains'] = $blocked_domains;
        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $defer_loading && $obj['defer_loading'] = $defer_loading;
        null !== $max_uses && $obj['max_uses'] = $max_uses;
        null !== $strict && $obj['strict'] = $strict;
        null !== $user_location && $obj['user_location'] = $user_location;

        return $obj;
    }

    /**
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $obj = clone $this;
        $obj['allowed_callers'] = $allowedCallers;

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
        $obj['allowed_domains'] = $allowedDomains;

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
        $obj['blocked_domains'] = $blockedDomains;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $obj = clone $this;
        $obj['defer_loading'] = $deferLoading;

        return $obj;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $obj = clone $this;
        $obj['max_uses'] = $maxUses;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

        return $obj;
    }

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     *
     * @param UserLocation|array{
     *   type: 'approximate',
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
        $obj['user_location'] = $userLocation;

        return $obj;
    }
}
