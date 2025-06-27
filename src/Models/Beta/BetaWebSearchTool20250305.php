<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Core\Serde\ListOf;

class BetaWebSearchTool20250305 implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    /**
     * @var list<string>|null $allowedDomains
     */
    #[Api(
        'allowed_domains',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $allowedDomains;

    /**
     * @var list<string>|null $blockedDomains
     */
    #[Api(
        'blocked_domains',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $blockedDomains;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    #[Api('max_uses', optional: true)]
    public ?int $maxUses;

    /**
     * @var array{
     *
     *     type?: string,
     *     city?: string|null,
     *     country?: string|null,
     *     region?: string|null,
     *     timezone?: string|null,
     *
     * }|null $userLocation
     */
    #[Api('user_location', optional: true)]
    public ?array $userLocation;

    /**
     * @param list<string>|null         $allowedDomains
     * @param list<string>|null         $blockedDomains
     * @param BetaCacheControlEphemeral $cacheControl
     * @param int|null                  $maxUses
     * @param array{
     *
     *     type?: string,
     *     city?: string|null,
     *     country?: string|null,
     *     region?: string|null,
     *     timezone?: string|null,
     *
     * }|null $userLocation
     */
    final public function __construct(
        string $name,
        string $type,
        array|None|null $allowedDomains = None::NOT_SET,
        array|None|null $blockedDomains = None::NOT_SET,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
        int|None|null $maxUses = None::NOT_SET,
        array|None|null $userLocation = None::NOT_SET,
    ) {

        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);

    }
}

BetaWebSearchTool20250305::_loadMetadata();
