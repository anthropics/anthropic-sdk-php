<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\ExternalKeys\ExternalKey;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\Geo;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyDeleteResponse;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyListParams;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyValidateResponse;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ExternalKeysRawContract;

/**
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig as ProviderConfigShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ExternalKeysRawService implements ExternalKeysRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create an external key config owned by the caller's organization.
     *
     * @param array{
     *   providerConfig: ProviderConfigShape,
     *   displayName?: string|null,
     *   geo?: Geo|value-of<Geo>,
     * }|ExternalKeyCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalKey>
     *
     * @throws APIException
     */
    public function create(
        array|ExternalKeyCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalKeyCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/external_keys?beta=true',
            body: (object) $parsed,
            options: $options,
            convert: ExternalKey::class,
        );
    }

    /**
     * @api
     *
     * Retrieve a single external key config in the caller's organization by ID.
     *
     * @param string $externalKeyID ID of the External Key
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalKey>
     *
     * @throws APIException
     */
    public function retrieve(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/external_keys/%1$s?beta=true', $externalKeyID],
            options: $requestOptions,
            convert: ExternalKey::class,
        );
    }

    /**
     * @api
     *
     * Partially update an external key config. Omitted fields are left unchanged.
     *
     * `display_name` is always editable. `geo` and `provider_config` cannot
     * be changed once any workspace references this config, because previously
     * encrypted data requires the original key identity to decrypt.
     *
     * @param string $externalKeyID ID of the External Key
     * @param array{
     *   displayName?: string|null,
     *   geo?: ExternalKeyUpdateParams\Geo|value-of<ExternalKeyUpdateParams\Geo>|null,
     *   providerConfig?: ProviderConfigShape1|null,
     * }|ExternalKeyUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalKey>
     *
     * @throws APIException
     */
    public function update(
        string $externalKeyID,
        array|ExternalKeyUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalKeyUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/external_keys/%1$s?beta=true', $externalKeyID],
            body: (object) $parsed,
            options: $options,
            convert: ExternalKey::class,
        );
    }

    /**
     * @api
     *
     * List external key configs in the caller's organization.
     *
     * Results are ordered by creation time (newest first). Use the
     * `next_page` cursor from the response to fetch subsequent pages.
     *
     * @param array{limit?: int, page?: string|null}|ExternalKeyListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ExternalKey>>
     *
     * @throws APIException
     */
    public function list(
        array|ExternalKeyListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalKeyListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/external_keys?beta=true',
            query: $parsed,
            options: $options,
            convert: ExternalKey::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete an external key config.
     *
     * The request is rejected if any workspace still references this config.
     *
     * @param string $externalKeyID ID of the External Key
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalKeyDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/external_keys/%1$s?beta=true', $externalKeyID],
            options: $requestOptions,
            convert: ExternalKeyDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Validate an external key config against the customer's KMS.
     *
     * Anthropic performs an encrypt/decrypt roundtrip against the configured
     * KMS key and waits up to 30 seconds for the result. The response status is
     * `success` if the roundtrip succeeded, or `failure` with an error
     * message if it failed or timed out.
     *
     * @param string $externalKeyID ID of the External Key
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalKeyValidateResponse>
     *
     * @throws APIException
     */
    public function validate(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/external_keys/%1$s/validate?beta=true', $externalKeyID,
            ],
            options: $requestOptions,
            convert: ExternalKeyValidateResponse::class,
        );
    }
}
