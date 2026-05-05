<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\UserProfileCreateParams\Relationship;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create User Profile.
 *
 * @see Anthropic\Services\Beta\UserProfilesService::create()
 *
 * @phpstan-type UserProfileCreateParamsShape = array{
 *   externalID?: string|null,
 *   metadata?: array<string,string>|null,
 *   name?: string|null,
 *   relationship?: null|Relationship|value-of<Relationship>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class UserProfileCreateParams implements BaseModel
{
    /** @use SdkModel<UserProfileCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Platform's own identifier for this user. Not enforced unique. Maximum 255 characters.
     */
    #[Optional('external_id', nullable: true)]
    public ?string $externalID;

    /**
     * Free-form key-value data to attach to this user profile. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters. Values must be non-empty strings.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Display name of the entity this profile represents. Required when relationship is `resold` (the resold-to company's name); optional otherwise. Maximum 255 characters.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * How the entity behind a user profile relates to the platform that owns the API key. `external`: an individual end-user of the platform. `resold`: a company the platform resells Claude access to. `internal`: the platform's own usage.
     *
     * @var value-of<Relationship>|null $relationship
     */
    #[Optional(enum: Relationship::class)]
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
     * @param array<string,string>|null $metadata
     * @param Relationship|value-of<Relationship>|null $relationship
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $externalID = null,
        ?array $metadata = null,
        ?string $name = null,
        Relationship|string|null $relationship = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $externalID && $self['externalID'] = $externalID;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $relationship && $self['relationship'] = $relationship;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Platform's own identifier for this user. Not enforced unique. Maximum 255 characters.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * Free-form key-value data to attach to this user profile. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters. Values must be non-empty strings.
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
     * Display name of the entity this profile represents. Required when relationship is `resold` (the resold-to company's name); optional otherwise. Maximum 255 characters.
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
     * @param Relationship|value-of<Relationship> $relationship
     */
    public function withRelationship(Relationship|string $relationship): self
    {
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
