<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ComplianceSettingsRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ComplianceSettings>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ComplianceSettingUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ComplianceSettings>
     *
     * @throws APIException
     */
    public function update(
        array|ComplianceSettingUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
