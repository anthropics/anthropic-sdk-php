<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Replace an organization webhook endpoint's signing secret. The old secret stops
 * working immediately. The new secret is returned only in this response.
 *
 * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\WebhooksService::regenerateSigningSecret()
 *
 * @phpstan-type WebhookRegenerateSigningSecretParamsShape = array{
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class WebhookRegenerateSigningSecretParams implements BaseModel
{
    /** @use SdkModel<WebhookRegenerateSigningSecretParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header.
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
    public static function with(?array $betas = null): self
    {
        $self = new self;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header.
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
