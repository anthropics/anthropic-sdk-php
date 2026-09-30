<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\Effective\EffectiveListParams;
use Anthropic\Beta\Organization\SpendLimits\SpendSummary;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface EffectiveRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|EffectiveListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SpendSummary>>
     *
     * @throws APIException
     */
    public function list(
        array|EffectiveListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
