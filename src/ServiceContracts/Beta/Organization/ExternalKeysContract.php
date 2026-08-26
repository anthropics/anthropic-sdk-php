<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\ExternalKeys\AWSExternalKeyConfig;
use Anthropic\Beta\Organization\ExternalKeys\AzureExternalKeyConfigParam;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKey;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\Geo;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyDeleteResponse;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyValidateResponse;
use Anthropic\Beta\Organization\ExternalKeys\GCPExternalKeyConfig;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig as ProviderConfigShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ExternalKeysContract
{
    /**
     * @api
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
    ): ExternalKey;

    /**
     * @api
     *
     * @param string $externalKeyID ID of the External Key
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKey;

    /**
     * @api
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
    ): ExternalKey;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
     *
     * @param string $externalKeyID ID of the External Key
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKeyDeleteResponse;

    /**
     * @api
     *
     * @param string $externalKeyID ID of the External Key
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validate(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKeyValidateResponse;
}
