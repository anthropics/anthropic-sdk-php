<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Update User Profile.
 *
 * @see Anthropic\Services\Beta\UserProfilesService::update()
 *
 * @phpstan-type UserProfileUpdateParamsShape = array{
 *   externalID?: string|null,
 *   metadata?: array<string,string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class UserProfileUpdateParams implements BaseModel
{
    /** @use SdkModel<UserProfileUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * If present, replaces the stored external_id. Omit to leave unchanged. Maximum 255 characters.
     */
    #[Optional('external_id', nullable: true)]
    public ?string $externalID;

    /**
     * Key-value pairs to merge into the stored metadata. Keys provided overwrite existing values. To remove a key, set its value to an empty string. Keys not provided are left unchanged. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $externalID = null,
        ?array $metadata = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $externalID && $self['externalID'] = $externalID;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * If present, replaces the stored external_id. Omit to leave unchanged. Maximum 255 characters.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * Key-value pairs to merge into the stored metadata. Keys provided overwrite existing values. To remove a key, set its value to an empty string. Keys not provided are left unchanged. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

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
