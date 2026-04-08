<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Vaults;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Vaults\Credentials\CredentialArchiveParams;
use Anthropic\Beta\Vaults\Credentials\CredentialCreateParams;
use Anthropic\Beta\Vaults\Credentials\CredentialDeleteParams;
use Anthropic\Beta\Vaults\Credentials\CredentialListParams;
use Anthropic\Beta\Vaults\Credentials\CredentialRetrieveParams;
use Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsDeletedCredential;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Vaults\CredentialsRawContract;

/**
 * @phpstan-import-type AuthShape from \Anthropic\Beta\Vaults\Credentials\CredentialCreateParams\Auth
 * @phpstan-import-type AuthShape from \Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams\Auth as AuthShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class CredentialsRawService implements CredentialsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Credential
     *
     * @param string $vaultID Path param: Path parameter vault_id
     * @param array{
     *   auth: AuthShape,
     *   displayName?: string|null,
     *   metadata?: array<string,string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CredentialCreateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CredentialCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/vaults/%1$s/credentials?beta=true', $vaultID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsCredential::class,
        );
    }

    /**
     * @api
     *
     * Get Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array{
     *   vaultID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|CredentialRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CredentialRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $vaultID = $parsed['vaultID'];
        unset($parsed['vaultID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/vaults/%1$s/credentials/%2$s?beta=true', $vaultID, $credentialID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsCredential::class,
        );
    }

    /**
     * @api
     *
     * Update Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array{
     *   vaultID: string,
     *   auth?: AuthShape1,
     *   displayName?: string|null,
     *   metadata?: array<string,string|null>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CredentialUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CredentialUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $vaultID = $parsed['vaultID'];
        unset($parsed['vaultID']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/vaults/%1$s/credentials/%2$s?beta=true', $vaultID, $credentialID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['vaultID']),
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsCredential::class,
        );
    }

    /**
     * @api
     *
     * List Credentials
     *
     * @param string $vaultID Path param: Path parameter vault_id
     * @param array{
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CredentialListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CredentialListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['includeArchived', 'limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/vaults/%1$s/credentials?beta=true', $vaultID],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['includeArchived' => 'include_archived'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsCredential::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array{
     *   vaultID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|CredentialDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CredentialDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $vaultID = $parsed['vaultID'];
        unset($parsed['vaultID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/vaults/%1$s/credentials/%2$s?beta=true', $vaultID, $credentialID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsDeletedCredential::class,
        );
    }

    /**
     * @api
     *
     * Archive Credential
     *
     * @param string $credentialID Path param: Path parameter credential_id
     * @param array{
     *   vaultID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|CredentialArchiveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CredentialArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $vaultID = $parsed['vaultID'];
        unset($parsed['vaultID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/vaults/%1$s/credentials/%2$s/archive?beta=true',
                $vaultID,
                $credentialID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsCredential::class,
        );
    }
}
