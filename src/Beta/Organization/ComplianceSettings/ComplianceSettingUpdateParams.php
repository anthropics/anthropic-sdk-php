<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingUpdateParams\State;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
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
 * @see Anthropic\Services\Beta\Organization\ComplianceSettingsService::update()
 *
 * @phpstan-import-type StateVariants from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingUpdateParams\State
 * @phpstan-import-type StateShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingUpdateParams\State
 *
 * @phpstan-type ComplianceSettingUpdateParamsShape = array{state: StateShape}
 */
final class ComplianceSettingUpdateParams implements BaseModel
{
    /** @use SdkModel<ComplianceSettingUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Desired state. Accepts the string shorthand "enabled" or "disabled" in place of the object form; the response always returns the canonical object form.
     *
     * @var StateVariants $state
     */
    #[Required(union: State::class)]
    public ComplianceSettingsStateEnabledParam|ComplianceSettingsStateDisabledParam $state;

    /**
     * `new ComplianceSettingUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComplianceSettingUpdateParams::with(state: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComplianceSettingUpdateParams)->withState(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param StateShape $state
     */
    public static function with(
        ComplianceSettingsStateEnabledParam|array|ComplianceSettingsStateDisabledParam $state,
    ): self {
        $self = new self;

        $self['state'] = $state;

        return $self;
    }

    /**
     * Desired state. Accepts the string shorthand "enabled" or "disabled" in place of the object form; the response always returns the canonical object form.
     *
     * @param StateShape $state
     */
    public function withState(
        ComplianceSettingsStateEnabledParam|array|ComplianceSettingsStateDisabledParam $state,
    ): self {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }
}
