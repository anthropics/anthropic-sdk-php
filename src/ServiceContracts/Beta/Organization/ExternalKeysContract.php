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
use Anthropic\Organization\ExternalKeys\ExternalKeyInWorkspacePolicyException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\UserProfiles\UserProfileNotFoundException;

/**
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig as ProviderConfigShape1
 */
interface ExternalKeysContract
{
    /**
     * @api
     *
     * @param ProviderConfigShape $providerConfig KMS provider identity and auth coordinates.
     * @param string|null $displayName Human-friendly display name.
     * @param Geo|value-of<Geo> $geo Data residency geo. Only `us` is supported.
     * @param string|null $userProfileID ID of a user profile to bind the key to. A user profile represents one of your customers: bind a customer's key to that customer's user profile. A key bound to a user profile can only be attached to a Workspace that has the same user profile, and the binding cannot be changed later. Omit this field only for your organization's own key, because a key created without a user profile ID can be attached to any Workspace, including another customer's.
     * @param RequestOpts|null $requestOptions
     *
     * @throws UserProfileNotFoundException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function create(
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfigParam $providerConfig,
        ?string $displayName = null,
        Geo|string|null $geo = null,
        ?string $userProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExternalKey;

    /**
     * @api
     *
     * @param string $externalKeyID ID of the External Key.
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
     * @param string $externalKeyID ID of the External Key.
     * @param string|null $displayName Human-friendly display name.
     * @param \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\Geo|value-of<\Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\Geo>|null $geo Data residency geo. Only `us` is supported.
     * @param ProviderConfigShape1|null $providerConfig KMS provider identity and auth coordinates.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ExternalKeyInWorkspacePolicyException
     * @throws SandboxEgressRestrictedException
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
     * @param int $limit Number of results per page.
     * @param string|null $page Opaque cursor from a previous response's `next_page`.
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
     * @param string $externalKeyID ID of the External Key.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ExternalKeyInWorkspacePolicyException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function delete(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKeyDeleteResponse;

    /**
     * @api
     *
     * @param string $externalKeyID ID of the External Key.
     * @param RequestOpts|null $requestOptions
     *
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function validate(
        string $externalKeyID,
        RequestOptions|array|null $requestOptions = null
    ): ExternalKeyValidateResponse;
}
