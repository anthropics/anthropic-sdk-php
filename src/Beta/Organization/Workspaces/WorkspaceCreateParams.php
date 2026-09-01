<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Workspace.
 *
 * @see Anthropic\Services\Beta\Organization\WorkspacesService::create()
 *
 * @phpstan-import-type DataResidencyCreateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig
 *
 * @phpstan-type WorkspaceCreateParamsShape = array{
 *   name: string,
 *   dataResidency?: null|DataResidencyCreateConfig|DataResidencyCreateConfigShape,
 *   displayColor?: string|null,
 *   externalKeyID?: string|null,
 *   tags?: array<string,string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WorkspaceCreateParams implements BaseModel
{
    /** @use SdkModel<WorkspaceCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Name of the Workspace.
     */
    #[Required]
    public string $name;

    /**
     * Data residency configuration for the workspace. If omitted, defaults to `workspace_geo: "us"`, `allowed_inference_geos: "unrestricted"`, and `default_inference_geo: "global"`.
     */
    #[Optional('data_residency', nullable: true)]
    public ?DataResidencyCreateConfig $dataResidency;

    /**
     * Hex color code representing the Workspace in the Anthropic Console.
     */
    #[Optional('display_color', nullable: true)]
    public ?string $displayColor;

    /**
     * ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. On
     * Claude Platform on AWS the value is the AWS KMS key ARN, and the key must be a
     * single-Region key in the same AWS account and Region as the Workspace. On that
     * platform the key is validated against this Workspace when it is attached, so a
     * key-policy problem is reported as an error on this request. This field is write-once:
     * once a key is attached to a Workspace it cannot be detached or replaced. To
     * rotate key material, rotate the underlying key on your cloud KMS; the
     * `external_key_id` stays the same.
     */
    #[Optional('external_key_id', nullable: true)]
    public ?string $externalKeyID;

    /**
     * User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     *
     * @var array<string,string>|null $tags
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $tags;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new WorkspaceCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceCreateParams)->withName(...)
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
     * @param DataResidencyCreateConfig|DataResidencyCreateConfigShape|null $dataResidency
     * @param array<string,string>|null $tags
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $name,
        DataResidencyCreateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        ?array $tags = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $dataResidency && $self['dataResidency'] = $dataResidency;
        null !== $displayColor && $self['displayColor'] = $displayColor;
        null !== $externalKeyID && $self['externalKeyID'] = $externalKeyID;
        null !== $tags && $self['tags'] = $tags;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Name of the Workspace.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Data residency configuration for the workspace. If omitted, defaults to `workspace_geo: "us"`, `allowed_inference_geos: "unrestricted"`, and `default_inference_geo: "global"`.
     *
     * @param DataResidencyCreateConfig|DataResidencyCreateConfigShape|null $dataResidency
     */
    public function withDataResidency(
        DataResidencyCreateConfig|array|null $dataResidency
    ): self {
        $self = clone $this;
        $self['dataResidency'] = $dataResidency;

        return $self;
    }

    /**
     * Hex color code representing the Workspace in the Anthropic Console.
     */
    public function withDisplayColor(?string $displayColor): self
    {
        $self = clone $this;
        $self['displayColor'] = $displayColor;

        return $self;
    }

    /**
     * ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. On
     * Claude Platform on AWS the value is the AWS KMS key ARN, and the key must be a
     * single-Region key in the same AWS account and Region as the Workspace. On that
     * platform the key is validated against this Workspace when it is attached, so a
     * key-policy problem is reported as an error on this request. This field is write-once:
     * once a key is attached to a Workspace it cannot be detached or replaced. To
     * rotate key material, rotate the underlying key on your cloud KMS; the
     * `external_key_id` stays the same.
     */
    public function withExternalKeyID(?string $externalKeyID): self
    {
        $self = clone $this;
        $self['externalKeyID'] = $externalKeyID;

        return $self;
    }

    /**
     * User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     *
     * @param array<string,string>|null $tags
     */
    public function withTags(?array $tags): self
    {
        $self = clone $this;
        $self['tags'] = $tags;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
