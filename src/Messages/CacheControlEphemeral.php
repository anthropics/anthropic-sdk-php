<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;

/**
 * @phpstan-type cache_control_ephemeral = array{type: string, ttl?: value-of<TTL>}
 */
final class CacheControlEphemeral implements BaseModel
{
    /** @use SdkModel<cache_control_ephemeral> */
    use SdkModel;

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
     * @var value-of<TTL>|null $ttl
     */
    #[Api(enum: TTL::class, optional: true)]
    public ?string $ttl;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TTL|value-of<TTL> $ttl
     */
    public static function with(TTL|string|null $ttl = null): self
    {
        $obj = new self;

        null !== $ttl && $obj->ttl = $ttl instanceof TTL ? $ttl->value : $ttl;

        return $obj;
    }

    /**
     * The time-to-live for the cache control breakpoint.
     *
     * This may be one the following values:
     * - `5m`: 5 minutes
     * - `1h`: 1 hour
     *
     * Defaults to `5m`.
     *
     * @param TTL|value-of<TTL> $ttl
     */
    public function withTTL(TTL|string $ttl): self
    {
        $obj = clone $this;
        $obj->ttl = $ttl instanceof TTL ? $ttl->value : $ttl;

        return $obj;
    }
}
