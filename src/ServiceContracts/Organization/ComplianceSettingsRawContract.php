<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ComplianceSettings\ComplianceSettingUpdateParams;
use Anthropic\Organization\ComplianceSettings\OrganizationComplianceSettings;
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
     * @return BaseResponse<OrganizationComplianceSettings>
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
     * @return BaseResponse<OrganizationComplianceSettings>
     *
     * @throws APIException
     */
    public function update(
        array|ComplianceSettingUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
