<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A tunnel's connector token.
 *
 * @phpstan-type BetaTunnelTokenShape = array{
 *   id: string, tunnelToken: string, type: 'tunnel_token'
 * }
 */
final class BetaTunnelToken implements BaseModel
{
    /** @use SdkModel<BetaTunnelTokenShape> */
    use SdkModel;

    /** @var 'tunnel_token' $type */
    #[Required]
    public string $type = 'tunnel_token';

    /**
     * Stable identifier for the current token value. Changes when the token is rotated.
     */
    #[Required]
    public string $id;

    /**
     * The connector token used to run the tunnel. Treat as a credential.
     */
    #[Required('tunnel_token')]
    public string $tunnelToken;

    /**
     * `new BetaTunnelToken()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTunnelToken::with(id: ..., tunnelToken: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTunnelToken)->withID(...)->withTunnelToken(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $id, string $tunnelToken): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['tunnelToken'] = $tunnelToken;

        return $self;
    }

    /**
     * Stable identifier for the current token value. Changes when the token is rotated.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The connector token used to run the tunnel. Treat as a credential.
     */
    public function withTunnelToken(string $tunnelToken): self
    {
        $self = clone $this;
        $self['tunnelToken'] = $tunnelToken;

        return $self;
    }

    /**
     * @param 'tunnel_token' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
