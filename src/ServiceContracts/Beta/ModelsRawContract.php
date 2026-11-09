<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Models\BetaModelInfo;
use Anthropic\Beta\Models\ModelListParams;
use Anthropic\Beta\Models\ModelRetrieveParams;
use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ModelsRawContract
{
    /**
     * @api
     *
     * @param string $modelID Model identifier or alias.
     * @param array<string,mixed>|ModelRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaModelInfo>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ModelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<BetaModelInfo>>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function list(
        array|ModelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
