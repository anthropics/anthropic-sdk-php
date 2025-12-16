<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaWebSearchTool20250305\AllowedCaller;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305\UserLocation;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type UserLocationShape from \Anthropic\Beta\Messages\BetaWebSearchTool20250305\UserLocation
 *
 * @phpstan-type BetaWebSearchTool20250305Shape = array{
 *   name: 'web_search',
 *   type: 'web_search_20250305',
 *   allowedCallers?: list<AllowedCaller|value-of<AllowedCaller>>|null,
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   deferLoading?: bool|null,
 *   maxUses?: int|null,
 *   strict?: bool|null,
 *   userLocation?: null|UserLocation|UserLocationShape,
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
    #[Required]
    public string $name = 'web_search';

    /** @var 'web_search_20250305' $type */
    #[Required]
    public string $type = 'web_search_20250305';

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

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
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Optional('defer_loading')]
    public ?bool $deferLoading;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Optional('max_uses', nullable: true)]
    public ?int $maxUses;

    #[Optional]
    public ?bool $strict;

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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     * @param UserLocationShape|null $userLocation
     */
    public static function with(
        ?array $allowedCallers = null,
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?int $maxUses = null,
        ?bool $strict = null,
        UserLocation|array|null $userLocation = null,
    ): self {
        $self = new self;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $allowedDomains && $self['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $self['blockedDomains'] = $blockedDomains;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $maxUses && $self['maxUses'] = $maxUses;
        null !== $strict && $self['strict'] = $strict;
        null !== $userLocation && $self['userLocation'] = $userLocation;

        return $self;
    }

    /**
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $self = clone $this;
        $self['allowedCallers'] = $allowedCallers;

        return $self;
    }

    /**
     * If provided, only these domains will be included in results. Cannot be used alongside `blocked_domains`.
     *
     * @param list<string>|null $allowedDomains
     */
    public function withAllowedDomains(?array $allowedDomains): self
    {
        $self = clone $this;
        $self['allowedDomains'] = $allowedDomains;

        return $self;
    }

    /**
     * If provided, these domains will never appear in results. Cannot be used alongside `allowed_domains`.
     *
     * @param list<string>|null $blockedDomains
     */
    public function withBlockedDomains(?array $blockedDomains): self
    {
        $self = clone $this;
        $self['blockedDomains'] = $blockedDomains;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $self = clone $this;
        $self['deferLoading'] = $deferLoading;

        return $self;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $self = clone $this;
        $self['maxUses'] = $maxUses;

        return $self;
    }

    public function withStrict(bool $strict): self
    {
        $self = clone $this;
        $self['strict'] = $strict;

        return $self;
    }

    /**
     * Parameters for the user's location. Used to provide more relevant search results.
     *
     * @param UserLocationShape|null $userLocation
     */
    public function withUserLocation(
        UserLocation|array|null $userLocation
    ): self {
        $self = clone $this;
        $self['userLocation'] = $userLocation;

        return $self;
    }
}
