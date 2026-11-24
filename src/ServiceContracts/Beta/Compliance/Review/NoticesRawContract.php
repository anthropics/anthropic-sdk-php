<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Compliance\Review;

use Anthropic\Beta\Compliance\Review\Notices\BetaComplianceReviewNotice;
use Anthropic\Beta\Compliance\Review\Notices\NoticeListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface NoticesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|NoticeListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaComplianceReviewNotice>>
     *
     * @throws APIException
     */
    public function list(
        array|NoticeListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
