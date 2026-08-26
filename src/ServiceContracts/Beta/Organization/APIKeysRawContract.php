<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\APIKeys\APIKey;
use Anthropic\Beta\Organization\APIKeys\APIKeyListParams;
use Anthropic\Beta\Organization\APIKeys\APIKeyUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface APIKeysRawContract
{
    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $apiKeyID ID of the API key
     * @param array<string,mixed>|APIKeyUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|APIKeyListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<APIKey>>
     *
     * @throws APIException
     */
    public function list(
        array|APIKeyListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
