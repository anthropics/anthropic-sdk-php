<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\Webhooks\DeletedOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\NewOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpointSigningSecret;
use Anthropic\Beta\Organization\Webhooks\WebhookCreateParams;
use Anthropic\Beta\Organization\Webhooks\WebhookDeleteParams;
use Anthropic\Beta\Organization\Webhooks\WebhookListParams;
use Anthropic\Beta\Organization\Webhooks\WebhookRegenerateSigningSecretParams;
use Anthropic\Beta\Organization\Webhooks\WebhookRetrieveParams;
use Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WebhooksRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WebhookCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<NewOrganizationWebhookEndpoint>
     *
     * @throws APIException
     */
    public function create(
        array|WebhookCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param array<string,mixed>|WebhookRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $webhookEndpointID path param: ID of the webhook endpoint
     * @param array<string,mixed>|WebhookUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WebhookListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<OrganizationWebhookEndpoint>>
     *
     * @throws APIException
     */
    public function list(
        array|WebhookListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param array<string,mixed>|WebhookDeleteParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $webhookEndpointID ID of the webhook endpoint
     * @param array<string,mixed>|WebhookRegenerateSigningSecretParams $params
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
    ): BaseResponse;
}
