<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The tunnel is connected through the Cloudflare connector. Its connector token is fetched with reveal_token. `type` is transitional: it reads `relay` for every tunnel once the Cloudflare transport is retired.
 *
 * @phpstan-type BetaCloudflareTunnelTransportShape = array{type: 'cloudflare'}
 */
final class BetaCloudflareTunnelTransport implements BaseModel
{
    /** @use SdkModel<BetaCloudflareTunnelTransportShape> */
    use SdkModel;

    /** @var 'cloudflare' $type */
    #[Required(type: new ConstantOf('cloudflare'))]
    public string $type = 'cloudflare';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'cloudflare' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
