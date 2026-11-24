<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\UserProfiles\Providers\Google;

use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedDataControls;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\DataControlRetrieveParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\DataControlUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DataControlsRawContract
{
    /**
     * @api
     *
     * @param string $userProfileID The ID of the user profile whose Google-managed data controls to retrieve (`uprof_...`).
     * @param array<string,mixed>|DataControlRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedDataControls>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userProfileID,
        array|DataControlRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userProfileID Path param: The ID of the user profile whose Google-managed data controls to update (`uprof_...`).
     * @param array<string,mixed>|DataControlUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedDataControls>
     *
     * @throws APIException
     */
    public function update(
        string $userProfileID,
        array|DataControlUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
