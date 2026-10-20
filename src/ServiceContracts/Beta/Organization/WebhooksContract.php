<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Webhooks\DeletedOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\NewOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpointSigningSecret;
use Anthropic\Beta\Organization\Webhooks\WebhookCreateParams\EnabledEvent;
use Anthropic\Beta\Organization\Webhooks\WebhookListParams\Order;
use Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams\State;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WebhooksContract
{
    /**
     * @api
     *
     * @param list<EnabledEvent|value-of<EnabledEvent>> $enabledEvents Body param: The event types to deliver to the endpoint. Must list at least one.
     * @param string $url body param: The HTTPS URL that deliveries are sent to
     * @param string $description body param: Notes about the endpoint
     * @param string $name body param: A short label for the endpoint
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $enabledEvents,
        string $url,
        ?string $description = null,
        ?string $name = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): NewOrganizationWebhookEndpoint;

    /**
     * @api
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `webhooks-2026-10-07` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $webhookEndpointID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationWebhookEndpoint;

    /**
     * @api
     *
     * @param string $webhookEndpointID path param: ID of the webhook endpoint
     * @param string $description body param: Notes about the endpoint
     * @param list<\Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams\EnabledEvent|value-of<\Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams\EnabledEvent>> $enabledEvents Body param: The event types to deliver to the endpoint. Replaces the whole set; an empty list leaves it unchanged.
     * @param string $name body param: A short label for the endpoint
     * @param State|value-of<State> $state Body param: `disabled` stops deliveries. `enabled` resumes them and clears `disabled_reason`. Events that happen while the endpoint is disabled are never delivered.
     * @param string $url body param: The HTTPS URL that deliveries are sent to
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $webhookEndpointID,
        ?string $description = null,
        ?array $enabledEvents = null,
        ?string $name = null,
        State|string|null $state = null,
        ?string $url = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationWebhookEndpoint;

    /**
     * @api
     *
     * @param string|null $afterID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string|null $beforeID Query param: ID of a webhook endpoint to use as a cursor. Returns the first `limit` endpoints that come before it in list order, not the `limit` endpoints just before it.
     * @param int $limit Query param: Number of items to return per page, up to `100`. The default, `0`, means `20`.
     * @param Order|value-of<Order>|null $order Query param: Sort order by `created_at`. Defaults to `desc`, newest first.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<OrganizationWebhookEndpoint>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `webhooks-2026-10-07` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $webhookEndpointID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedOrganizationWebhookEndpoint;

    /**
     * @api
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `webhooks-2026-10-07` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function regenerateSigningSecret(
        string $webhookEndpointID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationWebhookEndpointSigningSecret;
}
