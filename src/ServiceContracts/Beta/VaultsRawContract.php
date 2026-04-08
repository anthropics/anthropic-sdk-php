<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Vaults\BetaManagedAgentsDeletedVault;
use Anthropic\Beta\Vaults\BetaManagedAgentsVault;
use Anthropic\Beta\Vaults\VaultArchiveParams;
use Anthropic\Beta\Vaults\VaultCreateParams;
use Anthropic\Beta\Vaults\VaultDeleteParams;
use Anthropic\Beta\Vaults\VaultListParams;
use Anthropic\Beta\Vaults\VaultRetrieveParams;
use Anthropic\Beta\Vaults\VaultUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface VaultsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|VaultCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsVault>
     *
     * @throws APIException
     */
    public function create(
        array|VaultCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $vaultID Path parameter vault_id
     * @param array<string,mixed>|VaultRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsVault>
     *
     * @throws APIException
     */
    public function retrieve(
        string $vaultID,
        array|VaultRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $vaultID Path param: Path parameter vault_id
     * @param array<string,mixed>|VaultUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsVault>
     *
     * @throws APIException
     */
    public function update(
        string $vaultID,
        array|VaultUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|VaultListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsVault>>
     *
     * @throws APIException
     */
    public function list(
        array|VaultListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $vaultID Path parameter vault_id
     * @param array<string,mixed>|VaultDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeletedVault>
     *
     * @throws APIException
     */
    public function delete(
        string $vaultID,
        array|VaultDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $vaultID Path parameter vault_id
     * @param array<string,mixed>|VaultArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsVault>
     *
     * @throws APIException
     */
    public function archive(
        string $vaultID,
        array|VaultArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
