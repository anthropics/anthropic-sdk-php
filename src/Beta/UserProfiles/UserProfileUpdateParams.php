<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\UserProfileUpdateParams\AccessType;
use Anthropic\Beta\UserProfiles\UserProfileUpdateParams\Relationship;
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
 *   accessType?: null|AccessType|value-of<AccessType>,
 *   externalID?: string|null,
 *   metadata?: array<string,string>|null,
 *   name?: string|null,
 *   relationship?: null|Relationship|value-of<Relationship>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class UserProfileUpdateParams implements BaseModel
{
    /** @use SdkModel<UserProfileUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
     *
     * @var value-of<AccessType>|null $accessType
     */
    #[Optional('access_type', enum: AccessType::class, nullable: true)]
    public ?string $accessType;

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
     * If present, replaces the stored name. Omit to leave unchanged. Maximum 255 characters.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * How the entity behind a user profile relates to the platform that owns the API key. `external`: an individual end-user of the platform. `resold`: a company the platform resells Claude access to. `internal`: the platform's own usage.
     *
     * @var value-of<Relationship>|null $relationship
     */
    #[Optional(enum: Relationship::class, nullable: true)]
    public ?string $relationship;

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
     * @param AccessType|value-of<AccessType>|null $accessType
     * @param array<string,string>|null $metadata
     * @param Relationship|value-of<Relationship>|null $relationship
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        AccessType|string|null $accessType = null,
        ?string $externalID = null,
        ?array $metadata = null,
        ?string $name = null,
        Relationship|string|null $relationship = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $accessType && $self['accessType'] = $accessType;
        null !== $externalID && $self['externalID'] = $externalID;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $relationship && $self['relationship'] = $relationship;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
     *
     * @param AccessType|value-of<AccessType>|null $accessType
     */
    public function withAccessType(AccessType|string|null $accessType): self
    {
        $self = clone $this;
        $self['accessType'] = $accessType;

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
     * If present, replaces the stored name. Omit to leave unchanged. Maximum 255 characters.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * How the entity behind a user profile relates to the platform that owns the API key. `external`: an individual end-user of the platform. `resold`: a company the platform resells Claude access to. `internal`: the platform's own usage.
     *
     * @param Relationship|value-of<Relationship>|null $relationship
     */
    public function withRelationship(
        Relationship|string|null $relationship
    ): self {
        $self = clone $this;
        $self['relationship'] = $relationship;

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
