<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\UserProfiles;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\UserProfiles\ActionURLs\ActionURLCreateParams;
use Anthropic\UserProfiles\ActionURLs\UserProfileActionURL;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ActionURLsRawContract
{
    /**
     * @api
     *
     * @param string $userProfileID Path param: The ID of the user profile the action is for (`uprof_...`).
     * @param array<string,mixed>|ActionURLCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfileActionURL>
     *
     * @throws APIException
     */
    public function create(
        string $userProfileID,
        array|ActionURLCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
