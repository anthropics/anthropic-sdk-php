<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DataResidencyShape from \Anthropic\Beta\Organization\Workspaces\DataResidency
 *
 * @phpstan-type WorkspaceShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   compartmentID: string,
 *   createdAt: \DateTimeInterface,
 *   dataResidency: DataResidency|DataResidencyShape,
 *   displayColor: string,
 *   externalKeyID: string|null,
 *   name: string,
 *   tags: array<string,string>,
 *   type: 'workspace',
 * }
 */
final class Workspace implements BaseModel
{
    /** @use SdkModel<WorkspaceShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Workspaces, this is always `"workspace"`.
     *
     * @var 'workspace' $type
     */
    #[Required]
    public string $type = 'workspace';

    /**
     * ID of the Workspace.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string indicating when the Workspace was archived, or `null` if the Workspace is not archived.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * Identifier for this Workspace's encryption compartment. When you configure a
     * customer-managed encryption key (CMEK) on AWS, reference this value in your
     * KMS key-policy condition so the key is scoped to this compartment. On GCP and
     * Azure, Anthropic enforces the compartment binding automatically; you do not
     * need to reference this value in your key configuration. See the CMEK integration guide for the
     * required key configuration, including the value used during key validation.
     */
    #[Required('compartment_id')]
    public string $compartmentID;

    /**
     * RFC 3339 datetime string indicating when the Workspace was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Data residency configuration.
     */
    #[Required('data_residency')]
    public DataResidency $dataResidency;

    /**
     * Hex color code representing the Workspace in the Anthropic Console.
     */
    #[Required('display_color')]
    public string $displayColor;

    /**
     * ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. This
     * field is write-once: once a key is attached to a Workspace it cannot be
     * detached or replaced. To rotate key material, rotate the underlying key on
     * your cloud KMS; the `external_key_id` stays the same.
     */
    #[Required('external_key_id')]
    public ?string $externalKeyID;

    /**
     * Name of the Workspace.
     */
    #[Required]
    public string $name;

    /**
     * User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     *
     * @var array<string,string> $tags
     */
    #[Required(map: 'string')]
    public array $tags;

    /**
     * `new Workspace()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Workspace::with(
     *   id: ...,
     *   archivedAt: ...,
     *   compartmentID: ...,
     *   createdAt: ...,
     *   dataResidency: ...,
     *   displayColor: ...,
     *   externalKeyID: ...,
     *   name: ...,
     *   tags: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Workspace)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withCompartmentID(...)
     *   ->withCreatedAt(...)
     *   ->withDataResidency(...)
     *   ->withDisplayColor(...)
     *   ->withExternalKeyID(...)
     *   ->withName(...)
     *   ->withTags(...)
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
     * @param DataResidency|DataResidencyShape $dataResidency
     * @param array<string,string> $tags
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        string $compartmentID,
        \DateTimeInterface $createdAt,
        DataResidency|array $dataResidency,
        string $displayColor,
        ?string $externalKeyID,
        string $name,
        array $tags,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['compartmentID'] = $compartmentID;
        $self['createdAt'] = $createdAt;
        $self['dataResidency'] = $dataResidency;
        $self['displayColor'] = $displayColor;
        $self['externalKeyID'] = $externalKeyID;
        $self['name'] = $name;
        $self['tags'] = $tags;

        return $self;
    }

    /**
     * ID of the Workspace.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the Workspace was archived, or `null` if the Workspace is not archived.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * Identifier for this Workspace's encryption compartment. When you configure a
     * customer-managed encryption key (CMEK) on AWS, reference this value in your
     * KMS key-policy condition so the key is scoped to this compartment. On GCP and
     * Azure, Anthropic enforces the compartment binding automatically; you do not
     * need to reference this value in your key configuration. See the CMEK integration guide for the
     * required key configuration, including the value used during key validation.
     */
    public function withCompartmentID(string $compartmentID): self
    {
        $self = clone $this;
        $self['compartmentID'] = $compartmentID;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the Workspace was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Data residency configuration.
     *
     * @param DataResidency|DataResidencyShape $dataResidency
     */
    public function withDataResidency(DataResidency|array $dataResidency): self
    {
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
     * referenced key. Create key configurations with the External Keys API. This
     * field is write-once: once a key is attached to a Workspace it cannot be
     * detached or replaced. To rotate key material, rotate the underlying key on
     * your cloud KMS; the `external_key_id` stays the same.
     */
    public function withExternalKeyID(?string $externalKeyID): self
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
     * @param array<string,string> $tags
     */
    public function withTags(array $tags): self
    {
        $self = clone $this;
        $self['tags'] = $tags;

        return $self;
    }

    /**
     * Object type.
     *
     * For Workspaces, this is always `"workspace"`.
     *
     * @param 'workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
