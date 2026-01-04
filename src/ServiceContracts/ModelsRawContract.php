<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Models\ModelInfo;
use Anthropic\Models\ModelListParams;
use Anthropic\Models\ModelRetrieveParams;
use Anthropic\Page;
use Anthropic\RequestOptions;

interface ModelsRawContract
{
    /**
     * @api
     *
     * @param string $modelID model identifier or alias
     * @param array<string,mixed>|ModelRetrieveParams $params
     *
     * @return BaseResponse<ModelInfo>
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ModelListParams $params
     *
     * @return BaseResponse<Page<ModelInfo>>
     *
     * @throws APIException
     */
    public function list(
        array|ModelListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
