<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCacheControlEphemeral implements BaseModel
{
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
     * @var TTL::*|null $ttl
     */
    #[Api(enum: TTL::class, optional: true)]
    public ?string $ttl;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TTL::* $ttl
     */
    public static function with(?string $ttl = null): self
    {
        $obj = new self;

        null !== $ttl && $obj->ttl = $ttl;

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
     * @param TTL::* $ttl
     */
    public function withTTL(string $ttl): self
    {
        $obj = clone $this;
        $obj->ttl = $ttl;

        return $obj;
    }
}
