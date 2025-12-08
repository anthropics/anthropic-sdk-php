<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCacheControlEphemeralShape = array{
 *   type: 'ephemeral', ttl?: value-of<TTL>|null
 * }
 */
final class BetaCacheControlEphemeral implements BaseModel
{
    /** @use SdkModel<BetaCacheControlEphemeralShape> */
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
        $obj = new self;

        null !== $ttl && $obj['ttl'] = $ttl;

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
        $obj['ttl'] = $ttl;

        return $obj;
    }
}
