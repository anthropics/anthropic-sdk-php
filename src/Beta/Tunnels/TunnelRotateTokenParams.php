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
 * Rotates a tunnel's connector token. Rotation invalidates the current token for new connections and returns a fresh value; established connections are not severed. A connector restarted after rotation must use the new value.
 *
 * @see Anthropic\Services\Beta\TunnelsService::rotateToken()
 *
 * @phpstan-type TunnelRotateTokenParamsShape = array{
 *   reason?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TunnelRotateTokenParams implements BaseModel
{
    /** @use SdkModel<TunnelRotateTokenParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional free-text reason for the rotation, recorded for audit.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

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
        ?string $reason = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $reason && $self['reason'] = $reason;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Optional free-text reason for the rotation, recorded for audit.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

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
