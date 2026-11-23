<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabledParam;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabledParam;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ComplianceSettingsStateParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateParam
 */
interface ComplianceSettingsContract
{
    /**
     * @api
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional. Send `efs-2026-10-01` in this header to use this endpoint's beta features: additional parameters, accepted values and response fields.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null
    ): ComplianceSettings;

    /**
     * @api
     *
     * @param ComplianceSettingsStateParamShape $state Body param: Desired state. Accepts the string shorthand "enabled" or "disabled" in place of the object form; the response always returns the canonical object form.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional. Send `efs-2026-10-01` in this header to use this endpoint's beta features: additional parameters, accepted values and response fields.
     * @param RequestOpts|null $requestOptions
     *
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        ComplianceSettingsStateEnabledParam|array|ComplianceSettingsStateDisabledParam $state,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ComplianceSettings;
}
