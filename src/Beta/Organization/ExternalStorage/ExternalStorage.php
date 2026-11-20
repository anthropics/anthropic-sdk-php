<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Beta\Organization\ExternalStorage\ExternalStorage\ProviderConfig;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorage\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A storage bucket in the organization's own cloud account. Anthropic writes
 * inference data to it from each Workspace it is attached to.
 *
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorage\ProviderConfig
 * @phpstan-import-type StatusShape from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorage\Status
 * @phpstan-import-type ProviderConfigVariants from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorage\ProviderConfig
 * @phpstan-import-type StatusVariants from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorage\Status
 *
 * @phpstan-type ExternalStorageShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   displayName: string|null,
 *   providerConfig: ProviderConfigShape,
 *   setupTemplateVersion: string|null,
 *   status: StatusShape,
 *   type: 'external_storage',
 *   updatedAt: \DateTimeInterface,
 *   userProfileID: string|null,
 * }
 */
final class ExternalStorage implements BaseModel
{
    /** @use SdkModel<ExternalStorageShape> */
    use SdkModel;

    /** @var 'external_storage' $type */
    #[Required(type: new ConstantOf('external_storage'))]
    public string $type = 'external_storage';

    /**
     * The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     */
    #[Required]
    public string $id;

    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Human-friendly display name. Null if none was set.
     */
    #[Required('display_name')]
    public ?string $displayName;

    /** @var ProviderConfigVariants $providerConfig */
    #[Required('provider_config', union: ProviderConfig::class)]
    public AWSExternalStorageConfig|GCPExternalStorageConfig $providerConfig;

    /**
     * The version of Anthropic's setup template whose IAM role names this storage was found to use at activation. Null if no version was recorded, as for storage not yet activated or not on S3.
     */
    #[Required('setup_template_version')]
    public ?string $setupTemplateVersion;

    /** @var StatusVariants $status */
    #[Required(union: Status::class)]
    public PendingConfigurationExternalStorageStatus|AvailableExternalStorageStatus|ActiveExternalStorageStatus|DrainingExternalStorageStatus $status;

    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * The user profile the storage is bound to, or null.
     */
    #[Required('user_profile_id')]
    public ?string $userProfileID;

    /**
     * `new ExternalStorage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalStorage::with(
     *   id: ...,
     *   createdAt: ...,
     *   displayName: ...,
     *   providerConfig: ...,
     *   setupTemplateVersion: ...,
     *   status: ...,
     *   updatedAt: ...,
     *   userProfileID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalStorage())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDisplayName(...)
     *   ->withProviderConfig(...)
     *   ->withSetupTemplateVersion(...)
     *   ->withStatus(...)
     *   ->withUpdatedAt(...)
     *   ->withUserProfileID(...)
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
     * @param ProviderConfigShape $providerConfig
     * @param StatusShape $status
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        ?string $displayName,
        AWSExternalStorageConfig|array|GCPExternalStorageConfig $providerConfig,
        ?string $setupTemplateVersion,
        PendingConfigurationExternalStorageStatus|array|AvailableExternalStorageStatus|ActiveExternalStorageStatus|DrainingExternalStorageStatus $status,
        \DateTimeInterface $updatedAt,
        ?string $userProfileID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;
        $self['providerConfig'] = $providerConfig;
        $self['setupTemplateVersion'] = $setupTemplateVersion;
        $self['status'] = $status;
        $self['updatedAt'] = $updatedAt;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Human-friendly display name. Null if none was set.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * @param ProviderConfigShape $providerConfig
     */
    public function withProviderConfig(
        AWSExternalStorageConfig|array|GCPExternalStorageConfig $providerConfig
    ): self {
        $self = clone $this;
        $self['providerConfig'] = $providerConfig;

        return $self;
    }

    /**
     * The version of Anthropic's setup template whose IAM role names this storage was found to use at activation. Null if no version was recorded, as for storage not yet activated or not on S3.
     */
    public function withSetupTemplateVersion(
        ?string $setupTemplateVersion
    ): self {
        $self = clone $this;
        $self['setupTemplateVersion'] = $setupTemplateVersion;

        return $self;
    }

    /**
     * @param StatusShape $status
     */
    public function withStatus(
        PendingConfigurationExternalStorageStatus|array|AvailableExternalStorageStatus|ActiveExternalStorageStatus|DrainingExternalStorageStatus $status,
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param 'external_storage' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The user profile the storage is bound to, or null.
     */
    public function withUserProfileID(?string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }
}
