<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Models\BetaModelInfo;
use Anthropic\Beta\Models\ModelListParams;
use Anthropic\Beta\Models\ModelRetrieveParams;
use Anthropic\Core\Exceptions\APIException;
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
    ): BetaModelInfo;

    /**
     * @api
     *
     * @param array<mixed>|ModelListParams $params
     *
     * @return Page<BetaModelInfo>
     *
     * @throws APIException
     */
    public function list(
        array|ModelListParams $params,
        ?RequestOptions $requestOptions = null
    ): Page;
}
