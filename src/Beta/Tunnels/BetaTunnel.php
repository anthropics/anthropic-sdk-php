<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An MCP tunnel.
 *
 * @phpstan-import-type BetaTunnelTransportVariants from \Anthropic\Beta\Tunnels\BetaTunnelTransport
 * @phpstan-import-type BetaTunnelTransportShape from \Anthropic\Beta\Tunnels\BetaTunnelTransport
 *
 * @phpstan-type BetaTunnelShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   displayName: string|null,
 *   domain: string,
 *   transport: BetaTunnelTransportShape,
 *   type: 'tunnel',
 * }
 */
final class BetaTunnel implements BaseModel
{
    /** @use SdkModel<BetaTunnelShape> */
    use SdkModel;

    /** @var 'tunnel' $type */
    #[Required(type: new ConstantOf('tunnel'))]
    public string $type = 'tunnel';

    /**
     * Unique identifier for the tunnel, prefixed with `tnl_`.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string indicating when the tunnel was archived. Null if it is not archived.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * RFC 3339 datetime string indicating when the tunnel was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Human-readable name for the tunnel (1-255 characters). Null if unset.
     */
    #[Required('display_name')]
    public ?string $displayName;

    /**
     * Anthropic-assigned hostname for the tunnel. MCP server URLs whose host is a subdomain of this value are routed through the tunnel. Globally unique and never reused, even after the tunnel is archived.
     */
    #[Required]
    public string $domain;

    /**
     * How traffic reaches the tunnel. Chosen by Anthropic per organization when the tunnel is created; read-only and present on every tunnel, so automation can tell which connector to deploy. A union discriminated on `type`: `{"type": "cloudflare"}` or `{"type": "relay"}`. In the create response a `relay` tunnel's transport also carries `token`, its relay token, shown that once; no read carries a token.
     *
     * @var BetaTunnelTransportVariants $transport
     */
    #[Required(union: BetaTunnelTransport::class)]
    public BetaCloudflareTunnelTransport|BetaRelayTunnelTransport $transport;

    /**
     * `new BetaTunnel()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTunnel::with(
     *   id: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   displayName: ...,
     *   domain: ...,
     *   transport: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTunnel)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withDisplayName(...)
     *   ->withDomain(...)
     *   ->withTransport(...)
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
     *
     * @param BetaTunnelTransportShape $transport
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        ?string $displayName,
        string $domain,
        BetaCloudflareTunnelTransport|array|BetaRelayTunnelTransport $transport,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;
        $self['domain'] = $domain;
        $self['transport'] = $transport;

        return $self;
    }

    /**
     * Unique identifier for the tunnel, prefixed with `tnl_`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the tunnel was archived. Null if it is not archived.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the tunnel was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Human-readable name for the tunnel (1-255 characters). Null if unset.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Anthropic-assigned hostname for the tunnel. MCP server URLs whose host is a subdomain of this value are routed through the tunnel. Globally unique and never reused, even after the tunnel is archived.
     */
    public function withDomain(string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }

    /**
     * How traffic reaches the tunnel. Chosen by Anthropic per organization when the tunnel is created; read-only and present on every tunnel, so automation can tell which connector to deploy. A union discriminated on `type`: `{"type": "cloudflare"}` or `{"type": "relay"}`. In the create response a `relay` tunnel's transport also carries `token`, its relay token, shown that once; no read carries a token.
     *
     * @param BetaTunnelTransportShape $transport
     */
    public function withTransport(
        BetaCloudflareTunnelTransport|array|BetaRelayTunnelTransport $transport
    ): self {
        $self = clone $this;
        $self['transport'] = $transport;

        return $self;
    }

    /**
     * @param 'tunnel' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
