<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Webhooks\DeletedOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\NewOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpointSigningSecret;
use Anthropic\Beta\Organization\Webhooks\WebhookCreateParams;
use Anthropic\Beta\Organization\Webhooks\WebhookCreateParams\EnabledEvent;
use Anthropic\Beta\Organization\Webhooks\WebhookDeleteParams;
use Anthropic\Beta\Organization\Webhooks\WebhookListParams;
use Anthropic\Beta\Organization\Webhooks\WebhookListParams\Order;
use Anthropic\Beta\Organization\Webhooks\WebhookRegenerateSigningSecretParams;
use Anthropic\Beta\Organization\Webhooks\WebhookRetrieveParams;
use Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams;
use Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams\State;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\WebhooksRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WebhooksRawService implements WebhooksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
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
     * @param array{
     *   enabledEvents: list<EnabledEvent|value-of<EnabledEvent>>,
     *   url: string,
     *   description?: string,
     *   name?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WebhookCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<NewOrganizationWebhookEndpoint>
     *
     * @throws APIException
     */
    public function create(
        array|WebhookCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/webhooks?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'webhooks-2026-10-07']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.webhooks.create',
                route: '/v1/organizations/webhooks',
                createdId: 'anthropic.organization.webhook.id',
            )),
            convert: NewOrganizationWebhookEndpoint::class,
        );
    }

    /**
     * @api
     *
     * Retrieve an organization webhook endpoint by ID.
     *
     * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|WebhookRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationWebhookEndpoint>
     *
     * @throws APIException
     */
    public function retrieve(
        string $webhookEndpointID,
        array|WebhookRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/webhooks/%1$s?beta=true', $webhookEndpointID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'webhooks-2026-10-07']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.webhooks.retrieve',
                route: '/v1/organizations/webhooks/{webhook_endpoint_id}',
                attributes: ['anthropic.organization.webhook.id' => $webhookEndpointID],
            )),
            convert: OrganizationWebhookEndpoint::class,
        );
    }

    /**
     * @api
     *
     * Update an organization webhook endpoint. Only the fields you send are changed.
     *
     * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
     *
     * @param string $webhookEndpointID path param: ID of the webhook endpoint
     * @param array{
     *   description?: string,
     *   enabledEvents?: list<WebhookUpdateParams\EnabledEvent|value-of<WebhookUpdateParams\EnabledEvent>>,
     *   name?: string,
     *   state?: State|value-of<State>,
     *   url?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WebhookUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationWebhookEndpoint>
     *
     * @throws APIException
     */
    public function update(
        string $webhookEndpointID,
        array|WebhookUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/webhooks/%1$s?beta=true', $webhookEndpointID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'webhooks-2026-10-07']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.webhooks.update',
                route: '/v1/organizations/webhooks/{webhook_endpoint_id}',
                attributes: ['anthropic.organization.webhook.id' => $webhookEndpointID],
            )),
            convert: OrganizationWebhookEndpoint::class,
        );
    }

    /**
     * @api
     *
     * List the organization's webhook endpoints.
     *
     * An organization webhook endpoint belongs to the organization rather than to one of its workspaces. The list does not include webhook endpoints that
     * belong to a workspace.
     *
     * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
     *
     * @param array{
     *   afterID?: string|null,
     *   beforeID?: string|null,
     *   limit?: int,
     *   order?: Order|value-of<Order>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WebhookListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<OrganizationWebhookEndpoint>>
     *
     * @throws APIException
     */
    public function list(
        array|WebhookListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['afterID', 'beforeID', 'limit', 'order']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/webhooks?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['afterID' => 'after_id', 'beforeID' => 'before_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'webhooks-2026-10-07']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.webhooks.list',
                route: '/v1/organizations/webhooks',
                query: ['after_id', 'before_id', 'limit', 'order'],
            )),
            convert: OrganizationWebhookEndpoint::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Delete an organization webhook endpoint.
     *
     * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|WebhookDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedOrganizationWebhookEndpoint>
     *
     * @throws APIException
     */
    public function delete(
        string $webhookEndpointID,
        array|WebhookDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/webhooks/%1$s?beta=true', $webhookEndpointID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'webhooks-2026-10-07']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.webhooks.delete',
                route: '/v1/organizations/webhooks/{webhook_endpoint_id}',
                attributes: ['anthropic.organization.webhook.id' => $webhookEndpointID],
            )),
            convert: DeletedOrganizationWebhookEndpoint::class,
        );
    }

    /**
     * @api
     *
     * Replace an organization webhook endpoint's signing secret. The old secret stops
     * working immediately. The new secret is returned only in this response.
     *
     * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|WebhookRegenerateSigningSecretParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationWebhookEndpointSigningSecret>
     *
     * @throws APIException
     */
    public function regenerateSigningSecret(
        string $webhookEndpointID,
        array|WebhookRegenerateSigningSecretParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookRegenerateSigningSecretParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/webhooks/%1$s/regenerate_signing_secret?beta=true',
                $webhookEndpointID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'webhooks-2026-10-07']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.webhooks.regenerate_signing_secret',
                route: '/v1/organizations/webhooks/{webhook_endpoint_id}/regenerate_signing_secret',
                attributes: ['anthropic.organization.webhook.id' => $webhookEndpointID],
            )),
            convert: OrganizationWebhookEndpointSigningSecret::class,
        );
    }
}
