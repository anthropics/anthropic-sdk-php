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
 * Archives a tunnel certificate, removing it from the set Anthropic trusts for the tunnel. The certificate record is retained. Archiving the last non-archived certificate is permitted; the tunnel rejects MCP traffic until a new certificate is added.
 *
 * @see Anthropic\Services\Beta\Tunnels\CertificatesService::archive()
 *
 * @phpstan-type CertificateArchiveParamsShape = array{
 *   tunnelID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class CertificateArchiveParams implements BaseModel
{
    /** @use SdkModel<CertificateArchiveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $tunnelID;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new CertificateArchiveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CertificateArchiveParams::with(tunnelID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CertificateArchiveParams)->withTunnelID(...)
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
    public static function with(string $tunnelID, ?array $betas = null): self
    {
        $self = new self;

        $self['tunnelID'] = $tunnelID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    public function withTunnelID(string $tunnelID): self
    {
        $self = clone $this;
        $self['tunnelID'] = $tunnelID;

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
}
