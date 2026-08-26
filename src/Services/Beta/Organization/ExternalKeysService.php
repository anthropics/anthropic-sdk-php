<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\ExternalKeys\AWSExternalKeyConfig;
use Anthropic\Beta\Organization\ExternalKeys\AzureExternalKeyConfigParam;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKey;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\Geo;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyDeleteResponse;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyValidateResponse;
use Anthropic\Beta\Organization\ExternalKeys\GCPExternalKeyConfig;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ExternalKeysContract;

/**
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig as ProviderConfigShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ExternalKeysService implements ExternalKeysContract
{
    /**
     * @api
     */
    public ExternalKeysRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ExternalKeysRawService($client);
    }

    /**
     * @api
     *
     * Create an external key config owned by the caller's organization.
     *
     * @param ProviderConfigShape $providerConfig KMS provider identity and auth coordinates
     * @param string|null $displayName human-friendly display name
     * @param Geo|value-of<Geo> $geo Data residency geo. Only `us` is supported.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfigParam $providerConfig,
        ?string $displayName = null,
        Geo|string|null $geo = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExternalKey {
        $params = Util::removeNulls(
            [
                'providerConfig' => $providerConfig,
                'displayName' => $displayName,
                'geo' => $geo,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve a single external key config in the caller's organization by ID.
     *
     * @param string $externalKeyID ID of the External Key
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKey {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($externalKeyID, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string|null $displayName human-friendly display name
     * @param \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\Geo|value-of<\Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\Geo>|null $geo Data residency geo. Only `us` is supported.
     * @param ProviderConfigShape1|null $providerConfig KMS provider identity and auth coordinates
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $externalKeyID,
        ?string $displayName = null,
        \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\Geo|string|null $geo = null,
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfigParam|null $providerConfig = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExternalKey {
        $params = Util::removeNulls(
            [
                'displayName' => $displayName,
                'geo' => $geo,
                'providerConfig' => $providerConfig,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($externalKeyID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List external key configs in the caller's organization.
     *
     * Results are ordered by creation time (newest first). Use the
     * `next_page` cursor from the response to fetch subsequent pages.
     *
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ExternalKey>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(['limit' => $limit, 'page' => $page]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function delete(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKeyDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($externalKeyID, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function validate(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKeyValidateResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->validate($externalKeyID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
