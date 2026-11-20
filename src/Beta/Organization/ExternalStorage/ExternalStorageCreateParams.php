<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams\ProviderConfig;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Register a bucket in the organization's own cloud account. It is saved
 * as `pending_configuration` and verified when activated.
 *
 * @see Anthropic\Services\Beta\Organization\ExternalStorageService::create()
 *
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams\ProviderConfig
 * @phpstan-import-type ProviderConfigVariants from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams\ProviderConfig
 *
 * @phpstan-type ExternalStorageCreateParamsShape = array{
 *   providerConfig: ProviderConfigShape,
 *   displayName?: string|null,
 *   userProfileID?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ExternalStorageCreateParams implements BaseModel
{
    /** @use SdkModel<ExternalStorageCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var ProviderConfigVariants $providerConfig */
    #[Required('provider_config', union: ProviderConfig::class)]
    public AWSExternalStorageConfigParam|GCPExternalStorageConfigParam $providerConfig;

    /**
     * Human-friendly display name.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * The user profile to bind the storage to. It can't be changed later. The storage can be attached only to Workspaces with this profile, and the bucket's setup must name the same ID.
     */
    #[Optional('user_profile_id', nullable: true)]
    public ?string $userProfileID;

    /**
     * This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new ExternalStorageCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalStorageCreateParams::with(providerConfig: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalStorageCreateParams())->withProviderConfig(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        AWSExternalStorageConfigParam|array|GCPExternalStorageConfigParam $providerConfig,
        ?string $displayName = null,
        ?string $userProfileID = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['providerConfig'] = $providerConfig;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $userProfileID && $self['userProfileID'] = $userProfileID;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * @param ProviderConfigShape $providerConfig
     */
    public function withProviderConfig(
        AWSExternalStorageConfigParam|array|GCPExternalStorageConfigParam $providerConfig,
    ): self {
        $self = clone $this;
        $self['providerConfig'] = $providerConfig;

        return $self;
    }

    /**
     * Human-friendly display name.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * The user profile to bind the storage to. It can't be changed later. The storage can be attached only to Workspaces with this profile, and the bucket's setup must name the same ID.
     */
    public function withUserProfileID(?string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
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
