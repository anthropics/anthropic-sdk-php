<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabledParam;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabledParam;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ComplianceSettingsContract;

/**
 * @phpstan-import-type ComplianceSettingsStateParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateParam
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ComplianceSettingsService implements ComplianceSettingsContract
{
    /**
     * @api
     */
    public ComplianceSettingsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ComplianceSettingsRawService($client);
    }

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
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): ComplianceSettings {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
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
     * @param ComplianceSettingsStateParamShape $state Desired state. Accepts the string shorthand "enabled" or "disabled" in place of the object form; the response always returns the canonical object form.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        ComplianceSettingsStateEnabledParam|array|ComplianceSettingsStateDisabledParam $state,
        RequestOptions|array|null $requestOptions = null,
    ): ComplianceSettings {
        $params = Util::removeNulls(['state' => $state]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
