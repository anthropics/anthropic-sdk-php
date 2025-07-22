<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCacheControlEphemeral\TTL;

/**
 * @phpstan-type beta_cache_control_ephemeral_alias = array{
 *   type: string, ttl?: TTL::*
 * }
 */
final class BetaCacheControlEphemeral implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'ephemeral';

    /**
     * The time-to-live for the cache control breakpoint.
     *
     * This may be one the following values:
     * - `5m`: 5 minutes
     * - `1h`: 1 hour
     *
     * Defaults to `5m`.
     *
     * @var null|TTL::* $ttl
     */
    #[Api(optional: true)]
    public ?string $ttl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|TTL::* $ttl
     */
    final public function __construct(?string $ttl = null)
    {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $ttl && $this->ttl = $ttl;
    }
}
