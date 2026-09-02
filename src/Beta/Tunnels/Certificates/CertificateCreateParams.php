<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels\Certificates;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
 *
 * Registers a public CA certificate on a tunnel. Anthropic verifies the gateway's server certificate against this CA when it terminates the inner TLS session. A tunnel holds at most two non-archived certificates.
 *
 * @see Anthropic\Services\Beta\Tunnels\CertificatesService::create()
 *
 * @phpstan-type CertificateCreateParamsShape = array{
 *   caCertificatePEM: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class CertificateCreateParams implements BaseModel
{
    /** @use SdkModel<CertificateCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * PEM-encoded X.509 CA certificate. Must contain exactly one certificate and no private-key material. Maximum 8KB.
     */
    #[Required('ca_certificate_pem')]
    public string $caCertificatePEM;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    #[Optional]
    public ?string $workspaceID;

    /**
     * `new CertificateCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CertificateCreateParams::with(caCertificatePEM: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CertificateCreateParams)->withCACertificatePEM(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $caCertificatePEM,
        ?array $betas = null,
        ?string $workspaceID = null
    ): self {
        $self = new self;

        $self['caCertificatePEM'] = $caCertificatePEM;

        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * PEM-encoded X.509 CA certificate. Must contain exactly one certificate and no private-key material. Maximum 8KB.
     */
    public function withCACertificatePEM(string $caCertificatePEM): self
    {
        $self = clone $this;
        $self['caCertificatePEM'] = $caCertificatePEM;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }

    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
