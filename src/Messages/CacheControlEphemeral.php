<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;

/**
 * @phpstan-type CacheControlEphemeralShape = array{
 *   type?: 'ephemeral', ttl?: value-of<TTL>|null
 * }
 */
final class CacheControlEphemeral implements BaseModel
{
    /** @use SdkModel<CacheControlEphemeralShape> */
    use SdkModel;

    /** @var 'ephemeral' $type */
    #[Required]
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
    #[Optional(enum: TTL::class)]
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
        $self = new self;

        null !== $ttl && $self['ttl'] = $ttl;

        return $self;
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
        $self = clone $this;
        $self['ttl'] = $ttl;

        return $self;
    }
}
