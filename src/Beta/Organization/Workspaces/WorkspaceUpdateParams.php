<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update Workspace.
 *
 * @see Anthropic\Services\Beta\Organization\WorkspacesService::update()
 *
 * @phpstan-import-type DataResidencyUpdateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyUpdateConfig
 *
 * @phpstan-type WorkspaceUpdateParamsShape = array{
 *   dataResidency?: null|DataResidencyUpdateConfig|DataResidencyUpdateConfigShape,
 *   displayColor?: string|null,
 *   externalKeyID?: string|null,
 *   name?: string|null,
 *   tags?: array<string,string|null>|null,
 * }
 */
final class WorkspaceUpdateParams implements BaseModel
{
    /** @use SdkModel<WorkspaceUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Data residency configuration for the workspace.
     */
    #[Optional('data_residency', nullable: true)]
    public ?DataResidencyUpdateConfig $dataResidency;

    /**
     * Hex color code representing the Workspace in the Anthropic Console.
     */
    #[Optional('display_color')]
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
    #[Optional('external_key_id')]
    public ?string $externalKeyID;

    /**
     * Name of the Workspace.
     */
    #[Optional]
    public ?string $name;

    /**
     * User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     *
     * @var array<string,string|null>|null $tags
     */
    #[Optional(type: new MapOf('string', nullable: true), nullable: true)]
    public ?array $tags;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param DataResidencyUpdateConfig|DataResidencyUpdateConfigShape|null $dataResidency
     * @param array<string,string|null>|null $tags
     */
    public static function with(
        DataResidencyUpdateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        ?string $name = null,
        ?array $tags = null,
    ): self {
        $self = new self;

        null !== $dataResidency && $self['dataResidency'] = $dataResidency;
        null !== $displayColor && $self['displayColor'] = $displayColor;
        null !== $externalKeyID && $self['externalKeyID'] = $externalKeyID;
        null !== $name && $self['name'] = $name;
        null !== $tags && $self['tags'] = $tags;

        return $self;
    }

    /**
     * Data residency configuration for the workspace.
     *
     * @param DataResidencyUpdateConfig|DataResidencyUpdateConfigShape|null $dataResidency
     */
    public function withDataResidency(
        DataResidencyUpdateConfig|array|null $dataResidency
    ): self {
        $self = clone $this;
        $self['dataResidency'] = $dataResidency;

        return $self;
    }

    /**
     * Hex color code representing the Workspace in the Anthropic Console.
     */
    public function withDisplayColor(string $displayColor): self
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
    public function withExternalKeyID(string $externalKeyID): self
    {
        $self = clone $this;
        $self['externalKeyID'] = $externalKeyID;

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
     * User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     *
     * @param array<string,string|null>|null $tags
     */
    public function withTags(?array $tags): self
    {
        $self = clone $this;
        $self['tags'] = $tags;

        return $self;
    }
}
