<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\DataResidency\AllowedInferenceGeos;
use Anthropic\Beta\Organization\Workspaces\DataResidency\DefaultInferenceGeo;
use Anthropic\Beta\Organization\Workspaces\DataResidency\WorkspaceGeo;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AllowedInferenceGeosVariants from \Anthropic\Beta\Organization\Workspaces\DataResidency\AllowedInferenceGeos
 * @phpstan-import-type AllowedInferenceGeosShape from \Anthropic\Beta\Organization\Workspaces\DataResidency\AllowedInferenceGeos
 *
 * @phpstan-type DataResidencyShape = array{
 *   allowedInferenceGeos: AllowedInferenceGeosShape,
 *   defaultInferenceGeo: DefaultInferenceGeo|value-of<DefaultInferenceGeo>,
 *   workspaceGeo: WorkspaceGeo|value-of<WorkspaceGeo>,
 * }
 */
final class DataResidency implements BaseModel
{
    /** @use SdkModel<DataResidencyShape> */
    use SdkModel;

    /**
     * Permitted inference geo values. 'unrestricted' means all geos are allowed.
     *
     * @var AllowedInferenceGeosVariants $allowedInferenceGeos
     */
    #[Required('allowed_inference_geos', union: AllowedInferenceGeos::class)]
    public string|array $allowedInferenceGeos;

    /**
     * Default inference geo applied when requests omit the parameter.
     *
     * @var value-of<DefaultInferenceGeo> $defaultInferenceGeo
     */
    #[Required('default_inference_geo', enum: DefaultInferenceGeo::class)]
    public string $defaultInferenceGeo;

    /**
     * Geographic region for workspace data storage. Immutable after creation.
     *
     * @var value-of<WorkspaceGeo> $workspaceGeo
     */
    #[Required('workspace_geo', enum: WorkspaceGeo::class)]
    public string $workspaceGeo;

    /**
     * `new DataResidency()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DataResidency::with(
     *   allowedInferenceGeos: ..., defaultInferenceGeo: ..., workspaceGeo: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DataResidency)
     *   ->withAllowedInferenceGeos(...)
     *   ->withDefaultInferenceGeo(...)
     *   ->withWorkspaceGeo(...)
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
     * @param AllowedInferenceGeosShape $allowedInferenceGeos
     * @param DefaultInferenceGeo|value-of<DefaultInferenceGeo> $defaultInferenceGeo
     * @param WorkspaceGeo|value-of<WorkspaceGeo> $workspaceGeo
     */
    public static function with(
        string|array $allowedInferenceGeos,
        DefaultInferenceGeo|string $defaultInferenceGeo,
        WorkspaceGeo|string $workspaceGeo,
    ): self {
        $self = new self;

        $self['allowedInferenceGeos'] = $allowedInferenceGeos;
        $self['defaultInferenceGeo'] = $defaultInferenceGeo;
        $self['workspaceGeo'] = $workspaceGeo;

        return $self;
    }

    /**
     * Permitted inference geo values. 'unrestricted' means all geos are allowed.
     *
     * @param AllowedInferenceGeosShape $allowedInferenceGeos
     */
    public function withAllowedInferenceGeos(
        string|array $allowedInferenceGeos
    ): self {
        $self = clone $this;
        $self['allowedInferenceGeos'] = $allowedInferenceGeos;

        return $self;
    }

    /**
     * Default inference geo applied when requests omit the parameter.
     *
     * @param DefaultInferenceGeo|value-of<DefaultInferenceGeo> $defaultInferenceGeo
     */
    public function withDefaultInferenceGeo(
        DefaultInferenceGeo|string $defaultInferenceGeo
    ): self {
        $self = clone $this;
        $self['defaultInferenceGeo'] = $defaultInferenceGeo;

        return $self;
    }

    /**
     * Geographic region for workspace data storage. Immutable after creation.
     *
     * @param WorkspaceGeo|value-of<WorkspaceGeo> $workspaceGeo
     */
    public function withWorkspaceGeo(WorkspaceGeo|string $workspaceGeo): self
    {
        $self = clone $this;
        $self['workspaceGeo'] = $workspaceGeo;

        return $self;
    }
}
