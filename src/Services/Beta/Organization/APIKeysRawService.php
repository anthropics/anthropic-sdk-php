<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\APIKeys\APIKey;
use Anthropic\Beta\Organization\APIKeys\APIKeyListParams;
use Anthropic\Beta\Organization\APIKeys\APIKeyUpdateParams;
use Anthropic\Beta\Organization\APIKeys\APIKeyUpdateParams\Status;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\APIKeysRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class APIKeysRawService implements APIKeysRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get API Key
     *
     * @param string $apiKeyID ID of the API key
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKey>
     *
     * @throws APIException
     */
    public function retrieve(
        string $apiKeyID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/api_keys/%1$s?beta=true', $apiKeyID],
            options: $requestOptions,
            convert: APIKey::class,
        );
    }

    /**
     * @api
     *
     * Update API Key
     *
     * @param string $apiKeyID ID of the API key
     * @param array{
     *   name?: string|null, status?: Status|value-of<Status>|null
     * }|APIKeyUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKey>
     *
     * @throws APIException
     */
    public function update(
        string $apiKeyID,
        array|APIKeyUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = APIKeyUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/api_keys/%1$s?beta=true', $apiKeyID],
            body: (object) $parsed,
            options: $options,
            convert: APIKey::class,
        );
    }

    /**
     * @api
     *
     * List API Keys
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   createdByUserID?: string|null,
     *   limit?: int,
     *   status?: APIKeyListParams\Status|value-of<APIKeyListParams\Status>|null,
     *   workspaceID?: string|null,
     * }|APIKeyListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<APIKey>>
     *
     * @throws APIException
     */
    public function list(
        array|APIKeyListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = APIKeyListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/api_keys?beta=true',
            query: Util::array_transform_keys(
                $parsed,
                [
                    'afterID' => 'after_id',
                    'beforeID' => 'before_id',
                    'createdByUserID' => 'created_by_user_id',
                    'workspaceID' => 'workspace_id',
                ],
            ),
            options: $options,
            convert: APIKey::class,
            page: Page::class,
        );
    }
}
