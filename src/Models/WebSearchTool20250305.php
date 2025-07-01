<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class WebSearchTool20250305 implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    /**
     * @var null|list<string> $allowedDomains
     */
    #[Api(
        'allowed_domains',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $allowedDomains;

    /**
     * @var null|list<string> $blockedDomains
     */
    #[Api(
        'blocked_domains',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $blockedDomains;

    #[Api('cache_control', optional: true)]
    public CacheControlEphemeral $cacheControl;

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
     * @param null|list<string>     $allowedDomains
     * @param null|list<string>     $blockedDomains
     * @param CacheControlEphemeral $cacheControl
     * @param null|int              $maxUses
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
        null|array|None $allowedDomains = None::NOT_SET,
        null|array|None $blockedDomains = None::NOT_SET,
        CacheControlEphemeral|None $cacheControl = None::NOT_SET,
        null|int|None $maxUses = None::NOT_SET,
        null|array|None $userLocation = None::NOT_SET
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

WebSearchTool20250305::_loadMetadata();
