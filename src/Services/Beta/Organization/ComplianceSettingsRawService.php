<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ComplianceSettingsRawContract;

/**
 * @phpstan-import-type ComplianceSettingsStateParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateParam
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ComplianceSettingsRawService implements ComplianceSettingsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve your organization's Compliance Settings.
     *
     * Compliance Settings is a singleton resource: there is exactly one per
     * organization, addressed without an identifier. The `state` field reflects
     * whether the Compliance API is enabled. An organization with a parent
     * organization reads the state inherited from the parent's configuration.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ComplianceSettings>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/compliance_settings?beta=true',
            options: $requestOptions,
            convert: ComplianceSettings::class,
        );
    }

    /**
     * @api
     *
     * Update your organization's Compliance Settings.
     *
     * Setting `state` to `enabled` turns on the Compliance API and begins
     * capturing organization activity events. Setting it to `disabled` turns
     * both off. `state` reflects whether the Compliance API is enabled.
     *
     * A request that sets `state` to its current value succeeds and leaves the
     * resource unchanged. A `disabled` request stays in effect until a later
     * `enabled` request or the organization's next provisioning action that
     * enables Access Transparency: enabling Access Transparency also enables
     * the Compliance API, which serves its activity events, so such
     * provisioning (including re-runs) re-enables the Compliance API even
     * after a `disabled` request. Automated provisioning never disables
     * compliance settings.
     *
     * @param array{
     *   state: ComplianceSettingsStateParamShape
     * }|ComplianceSettingUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ComplianceSettings>
     *
     * @throws APIException
     */
    public function update(
        array|ComplianceSettingUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ComplianceSettingUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/compliance_settings?beta=true',
            body: (object) $parsed,
            options: $options,
            convert: ComplianceSettings::class,
        );
    }
}
