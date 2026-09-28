<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The tunnel is connected through Anthropic's relay. In the create response `token` is the tunnel's relay token, shown that once (only a hash is kept, so reveal_token refuses a relay tunnel and rotate_token issues a new one); reads never carry it.
 *
 * @phpstan-import-type BetaTunnelTokenShape from \Anthropic\Beta\Tunnels\BetaTunnelToken
 *
 * @phpstan-type BetaRelayTunnelTransportShape = array{
 *   type: 'relay', token?: null|BetaTunnelToken|BetaTunnelTokenShape
 * }
 */
final class BetaRelayTunnelTransport implements BaseModel
{
    /** @use SdkModel<BetaRelayTunnelTransportShape> */
    use SdkModel;

    /** @var 'relay' $type */
    #[Required(type: new ConstantOf('relay'))]
    public string $type = 'relay';

    /**
     * The tunnel's relay token. Present only in the create response, which issues it; absent on every read. Store it: Anthropic keeps only a hash, reveal_token refuses a relay tunnel, and rotate_token is the only way to obtain a new one.
     */
    #[Optional]
    public ?BetaTunnelToken $token;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaTunnelToken|BetaTunnelTokenShape|null $token
     */
    public static function with(BetaTunnelToken|array|null $token = null): self
    {
        $self = new self;

        null !== $token && $self['token'] = $token;

        return $self;
    }

    /**
     * @param 'relay' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The tunnel's relay token. Present only in the create response, which issues it; absent on every read. Store it: Anthropic keeps only a hash, reveal_token refuses a relay tunnel, and rotate_token is the only way to obtain a new one.
     *
     * @param BetaTunnelToken|BetaTunnelTokenShape $token
     */
    public function withToken(BetaTunnelToken|array $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }
}
