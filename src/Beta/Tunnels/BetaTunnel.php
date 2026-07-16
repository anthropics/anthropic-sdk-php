<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An MCP tunnel.
 *
 * @phpstan-type BetaTunnelShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   displayName: string|null,
 *   domain: string,
 *   type: 'tunnel',
 * }
 */
final class BetaTunnel implements BaseModel
{
    /** @use SdkModel<BetaTunnelShape> */
    use SdkModel;

    /** @var 'tunnel' $type */
    #[Required]
    public string $type = 'tunnel';

    /**
     * Unique identifier for the tunnel, prefixed with `tnl_`.
     */
    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * A timestamp in RFC 3339 format.
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
     * `new BetaTunnel()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTunnel::with(
     *   id: ..., archivedAt: ..., createdAt: ..., displayName: ..., domain: ...
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
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        ?string $displayName,
        string $domain,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;
        $self['domain'] = $domain;

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
     * A timestamp in RFC 3339 format.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
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
     * @param 'tunnel' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
