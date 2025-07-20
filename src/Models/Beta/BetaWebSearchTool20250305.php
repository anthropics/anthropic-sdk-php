<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Beta\BetaWebSearchTool20250305\UserLocation;

/**
 * @phpstan-type beta_web_search_tool20250305_alias = array{
 *   name: string,
 *   type: string,
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   maxUses?: int|null,
 *   userLocation?: UserLocation|null,
 * }
 */
final class BetaWebSearchTool20250305 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'web_search';

    #[Api]
    public string $type = 'web_search_20250305';

    /** @var null|list<string> $allowedDomains */
    #[Api(
        'allowed_domains',
        type: new ListOf('string'),
        nullable: true,
        optional: true,
    )]
    public ?array $allowedDomains;

    /** @var null|list<string> $blockedDomains */
    #[Api(
        'blocked_domains',
        type: new ListOf('string'),
        nullable: true,
        optional: true,
    )]
    public ?array $blockedDomains;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api('max_uses', optional: true)]
    public ?int $maxUses;

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
        ?BetaCacheControlEphemeral $cacheControl = null,
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
