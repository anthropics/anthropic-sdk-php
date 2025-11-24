<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Models\ModelInfo;
use Anthropic\Models\ModelListParams;
use Anthropic\Models\ModelRetrieveParams;
use Anthropic\Page;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @api
     *
     * @param array<mixed>|ModelRetrieveParams $params
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): ModelInfo;

    /**
     * @api
     *
     * @param array<mixed>|ModelListParams $params
     *
     * @return Page<ModelInfo>
     *
     * @throws APIException
     */
    public function list(
        array|ModelListParams $params,
        ?RequestOptions $requestOptions = null
    ): Page;
}
