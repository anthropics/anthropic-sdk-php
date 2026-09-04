<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabledParam;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabledParam;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type ComplianceSettingsStateParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateParam
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
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
    ): ComplianceSettings;

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
    ): ComplianceSettings;
}
