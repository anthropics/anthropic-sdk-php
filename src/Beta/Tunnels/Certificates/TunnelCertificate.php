<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels\Certificates;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A CA certificate attached to a tunnel.
 *
 * @phpstan-type TunnelCertificateShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   expiresAt: \DateTimeInterface|null,
 *   fingerprint: string,
 *   tunnelID: string,
 *   type: 'tunnel_certificate',
 * }
 */
final class TunnelCertificate implements BaseModel
{
    /** @use SdkModel<TunnelCertificateShape> */
    use SdkModel;

    /** @var 'tunnel_certificate' $type */
    #[Required]
    public string $type = 'tunnel_certificate';

    /**
     * Unique identifier for the certificate, prefixed with `tcrt_`.
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
     * A timestamp in RFC 3339 format.
     */
    #[Required('expires_at')]
    public ?\DateTimeInterface $expiresAt;

    /**
     * Lowercase hex SHA-256 fingerprint of the certificate's DER encoding.
     */
    #[Required]
    public string $fingerprint;

    /**
     * ID of the tunnel the certificate is registered against.
     */
    #[Required('tunnel_id')]
    public string $tunnelID;

    /**
     * `new TunnelCertificate()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TunnelCertificate::with(
     *   id: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   expiresAt: ...,
     *   fingerprint: ...,
     *   tunnelID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TunnelCertificate)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withExpiresAt(...)
     *   ->withFingerprint(...)
     *   ->withTunnelID(...)
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
        ?\DateTimeInterface $expiresAt,
        string $fingerprint,
        string $tunnelID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['expiresAt'] = $expiresAt;
        $self['fingerprint'] = $fingerprint;
        $self['tunnelID'] = $tunnelID;

        return $self;
    }

    /**
     * Unique identifier for the certificate, prefixed with `tcrt_`.
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
     * A timestamp in RFC 3339 format.
     */
    public function withExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Lowercase hex SHA-256 fingerprint of the certificate's DER encoding.
     */
    public function withFingerprint(string $fingerprint): self
    {
        $self = clone $this;
        $self['fingerprint'] = $fingerprint;

        return $self;
    }

    /**
     * ID of the tunnel the certificate is registered against.
     */
    public function withTunnelID(string $tunnelID): self
    {
        $self = clone $this;
        $self['tunnelID'] = $tunnelID;

        return $self;
    }

    /**
     * @param 'tunnel_certificate' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
