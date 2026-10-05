<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ComplianceSettings\ComplianceSettingsStateDisabledParam;
use Anthropic\Organization\ComplianceSettings\ComplianceSettingsStateEnabledParam;
use Anthropic\Organization\ComplianceSettings\OrganizationComplianceSettings;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ComplianceSettingsStateParamShape from \Anthropic\Organization\ComplianceSettings\ComplianceSettingsStateParam
 */
interface ComplianceSettingsContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): OrganizationComplianceSettings;

    /**
     * @api
     *
     * @param ComplianceSettingsStateParamShape $state Desired state. Accepts the string shorthand "enabled" or "disabled" in place of the object form; the response always returns the canonical object form.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        ComplianceSettingsStateEnabledParam|array|ComplianceSettingsStateDisabledParam $state,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationComplianceSettings;
}
