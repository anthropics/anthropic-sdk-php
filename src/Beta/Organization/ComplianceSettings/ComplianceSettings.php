<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings\State;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type StateVariants from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings\State
 * @phpstan-import-type StateShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings\State
 *
 * @phpstan-type ComplianceSettingsShape = array{
 *   state: StateShape, type: 'compliance_settings'
 * }
 */
final class ComplianceSettings implements BaseModel
{
    /** @use SdkModel<ComplianceSettingsShape> */
    use SdkModel;

    /** @var 'compliance_settings' $type */
    #[Required]
    public string $type = 'compliance_settings';

    /**
     * Whether the Compliance API is enabled for this organization.
     *
     * @var StateVariants $state
     */
    #[Required(union: State::class)]
    public ComplianceSettingsStateEnabled|ComplianceSettingsStateDisabled $state;

    /**
     * `new ComplianceSettings()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComplianceSettings::with(state: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComplianceSettings)->withState(...)
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
        ComplianceSettingsStateEnabled|array|ComplianceSettingsStateDisabled $state
    ): self {
        $self = new self;

        $self['state'] = $state;

        return $self;
    }

    /**
     * Whether the Compliance API is enabled for this organization.
     *
     * @param StateShape $state
     */
    public function withState(
        ComplianceSettingsStateEnabled|array|ComplianceSettingsStateDisabled $state
    ): self {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * @param 'compliance_settings' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
