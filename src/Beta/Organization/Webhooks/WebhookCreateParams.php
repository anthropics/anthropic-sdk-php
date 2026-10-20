<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Webhooks\WebhookCreateParams\EnabledEvent;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create an organization webhook endpoint.
 *
 * An organization webhook endpoint belongs to the organization rather than to one of its workspaces. An organization can have at most 32 organization
 * webhook endpoints, enabled or disabled.
 *
 * The response includes the endpoint's signing secret. No read returns it, so store
 * it when you receive it.
 *
 * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\WebhooksService::create()
 *
 * @phpstan-type WebhookCreateParamsShape = array{
 *   enabledEvents: list<EnabledEvent|value-of<EnabledEvent>>,
 *   url: string,
 *   description?: string|null,
 *   name?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WebhookCreateParams implements BaseModel
{
    /** @use SdkModel<WebhookCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The event types to deliver to the endpoint. Must list at least one.
     *
     * @var list<value-of<EnabledEvent>> $enabledEvents
     */
    #[Required('enabled_events', list: EnabledEvent::class)]
    public array $enabledEvents;

    /**
     * The HTTPS URL that deliveries are sent to.
     */
    #[Required]
    public string $url;

    /**
     * Notes about the endpoint.
     */
    #[Optional]
    public ?string $description;

    /**
     * A short label for the endpoint.
     */
    #[Optional]
    public ?string $name;

    /**
     * This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new WebhookCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookCreateParams::with(enabledEvents: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookCreateParams())->withEnabledEvents(...)->withURL(...)
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
     * @param list<EnabledEvent|value-of<EnabledEvent>> $enabledEvents
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        array $enabledEvents,
        string $url,
        ?string $description = null,
        ?string $name = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['enabledEvents'] = $enabledEvents;
        $self['url'] = $url;

        null !== $description && $self['description'] = $description;
        null !== $name && $self['name'] = $name;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The event types to deliver to the endpoint. Must list at least one.
     *
     * @param list<EnabledEvent|value-of<EnabledEvent>> $enabledEvents
     */
    public function withEnabledEvents(array $enabledEvents): self
    {
        $self = clone $this;
        $self['enabledEvents'] = $enabledEvents;

        return $self;
    }

    /**
     * The HTTPS URL that deliveries are sent to.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Notes about the endpoint.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * A short label for the endpoint.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
