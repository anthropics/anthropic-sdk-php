<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\ExternalKeys\ExternalKey;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyDeleteResponse;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyListParams;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyValidateResponse;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ExternalKeysRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ExternalKeyCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalKey>
     *
     * @throws APIException
     */
    public function create(
        array|ExternalKeyCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $externalKeyID ID of the External Key
     * @param array<string,mixed>|ExternalKeyUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ExternalKeyListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ExternalKey>>
     *
     * @throws APIException
     */
    public function list(
        array|ExternalKeyListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
