<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics\Apps\Chat;

use Anthropic\Beta\Organization\Analytics\AnalyticsProjectActivity;
use Anthropic\Beta\Organization\Analytics\Apps\Chat\Projects\ProjectListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ProjectsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ProjectListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsProjectActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|ProjectListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
