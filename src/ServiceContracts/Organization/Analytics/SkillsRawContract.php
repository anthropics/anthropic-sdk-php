<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Analytics;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Analytics\AnalyticsSkillActivity;
use Anthropic\Organization\Analytics\Skills\SkillListParams;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SkillsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SkillListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsSkillActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|SkillListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
