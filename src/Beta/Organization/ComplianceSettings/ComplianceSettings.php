<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ComplianceSettingsStateShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsState
 * @phpstan-import-type AccessTransparencyShape from \Anthropic\Beta\Organization\ComplianceSettings\AccessTransparency
 * @phpstan-import-type ComplianceSettingsStateVariants from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsState
 *
 * @phpstan-type ComplianceSettingsShape = array{
 *   state: ComplianceSettingsStateShape,
 *   type: 'compliance_settings',
 *   accessTransparency?: null|AccessTransparency|AccessTransparencyShape,
 * }
 */
final class ComplianceSettings implements BaseModel
{
    /** @use SdkModel<ComplianceSettingsShape> */
    use SdkModel;

    /** @var 'compliance_settings' $type */
    #[Required(type: new ConstantOf('compliance_settings'))]
    public string $type = 'compliance_settings';

    /**
     * Whether the Compliance API is enabled for this organization.
     *
     * @var ComplianceSettingsStateVariants $state
     */
    #[Required(union: ComplianceSettingsState::class)]
    public ComplianceSettingsStateEnabled|ComplianceSettingsStateDisabled $state;

    /**
     * Read-only. Whether Access Transparency is on for the organization. Returned only when the request sends the `anthropic-beta: efs-2026-10-01` header and Access Transparency is available to the organization; otherwise omitted. If the status can't be read, getting Compliance Settings returns an error; an update still saves, but then reports `disabled` whatever the real status, so get the settings again to check it.
     */
    #[Optional('access_transparency')]
    public ?AccessTransparency $accessTransparency;

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
     * (new ComplianceSettings())->withState(...)
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
     * @param ComplianceSettingsStateShape $state
     * @param AccessTransparency|AccessTransparencyShape|null $accessTransparency
     */
    public static function with(
        ComplianceSettingsStateEnabled|array|ComplianceSettingsStateDisabled $state,
        AccessTransparency|array|null $accessTransparency = null,
    ): self {
        $self = new self;

        $self['state'] = $state;

        null !== $accessTransparency && $self['accessTransparency'] = $accessTransparency;

        return $self;
    }

    /**
     * Whether the Compliance API is enabled for this organization.
     *
     * @param ComplianceSettingsStateShape $state
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

    /**
     * Read-only. Whether Access Transparency is on for the organization. Returned only when the request sends the `anthropic-beta: efs-2026-10-01` header and Access Transparency is available to the organization; otherwise omitted. If the status can't be read, getting Compliance Settings returns an error; an update still saves, but then reports `disabled` whatever the real status, so get the settings again to check it.
     *
     * @param AccessTransparency|AccessTransparencyShape $accessTransparency
     */
    public function withAccessTransparency(
        AccessTransparency|array $accessTransparency
    ): self {
        $self = clone $this;
        $self['accessTransparency'] = $accessTransparency;

        return $self;
    }
}
