<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Vaults;

use Anthropic\Beta\Vaults\Credentials\CredentialArchiveParams;
use Anthropic\Beta\Vaults\Credentials\CredentialCreateParams;
use Anthropic\Beta\Vaults\Credentials\CredentialDeleteParams;
use Anthropic\Beta\Vaults\Credentials\CredentialListParams;
use Anthropic\Beta\Vaults\Credentials\CredentialRetrieveParams;
use Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsDeletedCredential;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface CredentialsRawContract
{
    /**
     * @api
     *
     * @param string $vaultID Path param: Path parameter vault_id
     * @param array<string,mixed>|CredentialCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsCredential>
     *
     * @throws APIException
     */
    public function create(
        string $vaultID,
        array|CredentialCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array<string,mixed>|CredentialRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsCredential>
     *
     * @throws APIException
     */
    public function retrieve(
        string $credentialID,
        array|CredentialRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array<string,mixed>|CredentialUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsCredential>
     *
     * @throws APIException
     */
    public function update(
        string $credentialID,
        array|CredentialUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $vaultID Path param: Path parameter vault_id
     * @param array<string,mixed>|CredentialListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ManagedAgentsCredential>>
     *
     * @throws APIException
     */
    public function list(
        string $vaultID,
        array|CredentialListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array<string,mixed>|CredentialDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsDeletedCredential>
     *
     * @throws APIException
     */
    public function delete(
        string $credentialID,
        array|CredentialDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array<string,mixed>|CredentialArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsCredential>
     *
     * @throws APIException
     */
    public function archive(
        string $credentialID,
        array|CredentialArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
