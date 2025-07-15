<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaWebSearchTool20250305\UserLocation;

final class BetaWebSearchTool20250305 implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    /** @var null|list<string> $allowedDomains */
    #[Api(
        'allowed_domains',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $allowedDomains;

    /** @var null|list<string> $blockedDomains */
    #[Api(
        'blocked_domains',
        type: new UnionOf([new ListOf('string'), 'null']),
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
        string $name,
        string $type,
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?int $maxUses = null,
        ?UserLocation $userLocation = null,
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->allowedDomains = $allowedDomains;
        $this->blockedDomains = $blockedDomains;
        $this->cacheControl = $cacheControl;
        $this->maxUses = $maxUses;
        $this->userLocation = $userLocation;
    }
}

BetaWebSearchTool20250305::_loadMetadata();
