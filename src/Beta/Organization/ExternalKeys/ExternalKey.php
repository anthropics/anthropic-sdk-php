<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Beta\Organization\ExternalKeys\ExternalKey\Attachment;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKey\ProviderConfig;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * CMEK external key config belonging to the caller's organization.
 *
 * Configs are organization-scoped. Workspaces attach to a config; once any
 * workspace references it, the provider fields become effectively immutable
 * (existing encrypted data needs the config for decrypt).
 *
 * @phpstan-import-type AttachmentVariants from \Anthropic\Beta\Organization\ExternalKeys\ExternalKey\Attachment
 * @phpstan-import-type ProviderConfigVariants from \Anthropic\Beta\Organization\ExternalKeys\ExternalKey\ProviderConfig
 * @phpstan-import-type AttachmentShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKey\Attachment
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKey\ProviderConfig
 *
 * @phpstan-type ExternalKeyShape = array{
 *   id: string,
 *   attachment: AttachmentShape,
 *   createdAt: \DateTimeInterface,
 *   displayName: string|null,
 *   geo: string,
 *   providerConfig: ProviderConfigShape,
 *   type: 'external_key',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class ExternalKey implements BaseModel
{
    /** @use SdkModel<ExternalKeyShape> */
    use SdkModel;

    /** @var 'external_key' $type */
    #[Required]
    public string $type = 'external_key';

    /**
     * Identifier of the external key config. A tagged ID prefixed `ekey_`, or — for organizations on the Claude Platform on AWS — the AWS KMS key ARN.
     */
    #[Required]
    public string $id;

    /**
     * Whether any workspace uses this config to encrypt its data — counting live and archived workspaces (an archived workspace's data remains encrypted under the config), excluding deleted ones. Only an attached config is used by the encryption path; an `unattached` config is inert and can be deleted.
     *
     * @var AttachmentVariants $attachment
     */
    #[Required(union: Attachment::class)]
    public ExternalKeyAttachedAttachment|ExternalKeyUnattachedAttachment $attachment;

    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Human-friendly display name. Null if none was set.
     */
    #[Required('display_name')]
    public ?string $displayName;

    /**
     * Data residency geo. Selects which regional validator handles this key's encrypt/decrypt roundtrips.
     */
    #[Required]
    public string $geo;

    /**
     * KMS provider identity and auth coordinates.
     *
     * @var ProviderConfigVariants $providerConfig
     */
    #[Required('provider_config', union: ProviderConfig::class)]
    public AWSExternalKeyConfig|GCPExternalKeyConfig|AzureExternalKeyConfig $providerConfig;

    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new ExternalKey()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalKey::with(
     *   id: ...,
     *   attachment: ...,
     *   createdAt: ...,
     *   displayName: ...,
     *   geo: ...,
     *   providerConfig: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalKey)
     *   ->withID(...)
     *   ->withAttachment(...)
     *   ->withCreatedAt(...)
     *   ->withDisplayName(...)
     *   ->withGeo(...)
     *   ->withProviderConfig(...)
     *   ->withUpdatedAt(...)
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
     * @param AttachmentShape $attachment
     * @param ProviderConfigShape $providerConfig
     */
    public static function with(
        string $id,
        ExternalKeyAttachedAttachment|array|ExternalKeyUnattachedAttachment $attachment,
        \DateTimeInterface $createdAt,
        ?string $displayName,
        string $geo,
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfig $providerConfig,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['attachment'] = $attachment;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;
        $self['geo'] = $geo;
        $self['providerConfig'] = $providerConfig;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Identifier of the external key config. A tagged ID prefixed `ekey_`, or — for organizations on the Claude Platform on AWS — the AWS KMS key ARN.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Whether any workspace uses this config to encrypt its data — counting live and archived workspaces (an archived workspace's data remains encrypted under the config), excluding deleted ones. Only an attached config is used by the encryption path; an `unattached` config is inert and can be deleted.
     *
     * @param AttachmentShape $attachment
     */
    public function withAttachment(
        ExternalKeyAttachedAttachment|array|ExternalKeyUnattachedAttachment $attachment,
    ): self {
        $self = clone $this;
        $self['attachment'] = $attachment;

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
     * Data residency geo. Selects which regional validator handles this key's encrypt/decrypt roundtrips.
     */
    public function withGeo(string $geo): self
    {
        $self = clone $this;
        $self['geo'] = $geo;

        return $self;
    }

    /**
     * KMS provider identity and auth coordinates.
     *
     * @param ProviderConfigShape $providerConfig
     */
    public function withProviderConfig(
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfig $providerConfig,
    ): self {
        $self = clone $this;
        $self['providerConfig'] = $providerConfig;

        return $self;
    }

    /**
     * @param 'external_key' $type
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
}
