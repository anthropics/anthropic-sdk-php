<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsArtifactActivity;
use Anthropic\Beta\Organization\Analytics\Artifacts\ArtifactListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ArtifactsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ArtifactListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsArtifactActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|ArtifactListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
