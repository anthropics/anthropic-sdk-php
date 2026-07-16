<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
 *
 * Creates a tunnel. Creation allocates a fresh hostname and provisions the tunnel; it is not idempotent. The new tunnel rejects MCP traffic until at least one CA certificate is added.
 *
 * @see Anthropic\Services\Beta\TunnelsService::create()
 *
 * @phpstan-type TunnelCreateParamsShape = array{
 *   displayName?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TunnelCreateParams implements BaseModel
{
    /** @use SdkModel<TunnelCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional human-readable name for the tunnel (1-255 characters).
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
        ?string $displayName = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Optional human-readable name for the tunnel (1-255 characters).
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

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
