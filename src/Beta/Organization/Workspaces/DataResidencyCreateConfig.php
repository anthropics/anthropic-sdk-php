<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig\AllowedInferenceGeos;
use Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig\DefaultInferenceGeo;
use Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig\WorkspaceGeo;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AllowedInferenceGeosVariants from \Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig\AllowedInferenceGeos
 * @phpstan-import-type AllowedInferenceGeosShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig\AllowedInferenceGeos
 *
 * @phpstan-type DataResidencyCreateConfigShape = array{
 *   allowedInferenceGeos?: AllowedInferenceGeosShape|null,
 *   defaultInferenceGeo?: null|DefaultInferenceGeo|value-of<DefaultInferenceGeo>,
 *   workspaceGeo?: null|WorkspaceGeo|value-of<WorkspaceGeo>,
 * }
 */
final class DataResidencyCreateConfig implements BaseModel
{
    /** @use SdkModel<DataResidencyCreateConfigShape> */
    use SdkModel;

    /**
     * Permitted inference geo values. Defaults to 'unrestricted' if omitted, which allows all geos. Use the string 'unrestricted' to allow all geos, or a list of specific geos.
     *
     * @var AllowedInferenceGeosVariants|null $allowedInferenceGeos
     */
    #[Optional(
        'allowed_inference_geos',
        union: AllowedInferenceGeos::class,
        nullable: true
    )]
    public string|array|null $allowedInferenceGeos;

    /**
     * Default inference geo applied when requests omit the parameter. Defaults to 'global' if omitted. Must be a member of `allowed_inference_geos` unless `allowed_inference_geos` is `"unrestricted"`.
     *
     * @var value-of<DefaultInferenceGeo>|null $defaultInferenceGeo
     */
    #[Optional(
        'default_inference_geo',
        enum: DefaultInferenceGeo::class,
        nullable: true
    )]
    public ?string $defaultInferenceGeo;

    /**
     * Geographic region for workspace data storage. Immutable after creation. Defaults to 'us' if omitted.
     *
     * @var value-of<WorkspaceGeo>|null $workspaceGeo
     */
    #[Optional('workspace_geo', enum: WorkspaceGeo::class, nullable: true)]
    public ?string $workspaceGeo;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AllowedInferenceGeosShape|null $allowedInferenceGeos
     * @param DefaultInferenceGeo|value-of<DefaultInferenceGeo>|null $defaultInferenceGeo
     * @param WorkspaceGeo|value-of<WorkspaceGeo>|null $workspaceGeo
     */
    public static function with(
        string|array|null $allowedInferenceGeos = null,
        DefaultInferenceGeo|string|null $defaultInferenceGeo = null,
        WorkspaceGeo|string|null $workspaceGeo = null,
    ): self {
        $self = new self;

        null !== $allowedInferenceGeos && $self['allowedInferenceGeos'] = $allowedInferenceGeos;
        null !== $defaultInferenceGeo && $self['defaultInferenceGeo'] = $defaultInferenceGeo;
        null !== $workspaceGeo && $self['workspaceGeo'] = $workspaceGeo;

        return $self;
    }

    /**
     * Permitted inference geo values. Defaults to 'unrestricted' if omitted, which allows all geos. Use the string 'unrestricted' to allow all geos, or a list of specific geos.
     *
     * @param AllowedInferenceGeosShape|null $allowedInferenceGeos
     */
    public function withAllowedInferenceGeos(
        string|array|null $allowedInferenceGeos
    ): self {
        $self = clone $this;
        $self['allowedInferenceGeos'] = $allowedInferenceGeos;

        return $self;
    }

    /**
     * Default inference geo applied when requests omit the parameter. Defaults to 'global' if omitted. Must be a member of `allowed_inference_geos` unless `allowed_inference_geos` is `"unrestricted"`.
     *
     * @param DefaultInferenceGeo|value-of<DefaultInferenceGeo>|null $defaultInferenceGeo
     */
    public function withDefaultInferenceGeo(
        DefaultInferenceGeo|string|null $defaultInferenceGeo
    ): self {
        $self = clone $this;
        $self['defaultInferenceGeo'] = $defaultInferenceGeo;

        return $self;
    }

    /**
     * Geographic region for workspace data storage. Immutable after creation. Defaults to 'us' if omitted.
     *
     * @param WorkspaceGeo|value-of<WorkspaceGeo>|null $workspaceGeo
     */
    public function withWorkspaceGeo(
        WorkspaceGeo|string|null $workspaceGeo
    ): self {
        $self = clone $this;
        $self['workspaceGeo'] = $workspaceGeo;

        return $self;
    }
}
