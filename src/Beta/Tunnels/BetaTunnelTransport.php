<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How traffic reaches a tunnel: `{"type": "cloudflare"}` or `{"type": "relay"}`. In the create response a `relay` tunnel's transport also carries its relay `token`; reads never carry a token.
 *
 * @phpstan-import-type BetaCloudflareTunnelTransportShape from \Anthropic\Beta\Tunnels\BetaCloudflareTunnelTransport
 * @phpstan-import-type BetaRelayTunnelTransportShape from \Anthropic\Beta\Tunnels\BetaRelayTunnelTransport
 *
 * @phpstan-type BetaTunnelTransportVariants = BetaCloudflareTunnelTransport|BetaRelayTunnelTransport
 * @phpstan-type BetaTunnelTransportShape = BetaTunnelTransportVariants|BetaCloudflareTunnelTransportShape|BetaRelayTunnelTransportShape
 */
final class BetaTunnelTransport implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'cloudflare' => BetaCloudflareTunnelTransport::class,
            'relay' => BetaRelayTunnelTransport::class,
        ];
    }
}
