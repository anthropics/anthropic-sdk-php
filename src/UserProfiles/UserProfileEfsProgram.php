<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A user profile's standing in Enterprise Frontier Safeguards, a program under which Anthropic approves the entity the profile represents and may approve any of the program's features.
 *
 * @phpstan-import-type UserProfileEfsFeatureShape from \Anthropic\UserProfiles\UserProfileEfsFeature
 *
 * @phpstan-type UserProfileEfsProgramShape = array{
 *   features: array<string,UserProfileEfsFeature|UserProfileEfsFeatureShape>,
 *   status: UserProfileProgramStatus|value-of<UserProfileProgramStatus>,
 * }
 */
final class UserProfileEfsProgram implements BaseModel
{
    /** @use SdkModel<UserProfileEfsProgramShape> */
    use SdkModel;

    /**
     * The program's features, keyed by feature: `data_retention_exemption` (use of models that normally require data retention, without the data being retained), `cmek` (customer-managed encryption keys) and `storage` (customer-owned storage). Every feature that the caller's organization may read has a key, whether or not it is approved; a missing key does not mean that the feature is inactive. Anthropic may add features; ignore a key you do not recognize.
     *
     * @var array<string,UserProfileEfsFeature> $features
     */
    #[Required(map: UserProfileEfsFeature::class)]
    public array $features;

    /**
     * Anthropic's decision on the entity the profile represents: `pending` while it is awaited, `active` once Anthropic has approved the entity for the program, or `rejected` once Anthropic has declined or has removed the entity from the program. `active` does not mean that any one feature is approved: read the feature you need in `features`.
     *
     * @var value-of<UserProfileProgramStatus> $status
     */
    #[Required(enum: UserProfileProgramStatus::class)]
    public string $status;

    /**
     * `new UserProfileEfsProgram()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfileEfsProgram::with(features: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfileEfsProgram())->withFeatures(...)->withStatus(...)
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
     * @param array<string,UserProfileEfsFeature|UserProfileEfsFeatureShape> $features
     * @param UserProfileProgramStatus|value-of<UserProfileProgramStatus> $status
     */
    public static function with(
        array $features,
        UserProfileProgramStatus|string $status
    ): self {
        $self = new self;

        $self['features'] = $features;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The program's features, keyed by feature: `data_retention_exemption` (use of models that normally require data retention, without the data being retained), `cmek` (customer-managed encryption keys) and `storage` (customer-owned storage). Every feature that the caller's organization may read has a key, whether or not it is approved; a missing key does not mean that the feature is inactive. Anthropic may add features; ignore a key you do not recognize.
     *
     * @param array<string,UserProfileEfsFeature|UserProfileEfsFeatureShape> $features
     */
    public function withFeatures(array $features): self
    {
        $self = clone $this;
        $self['features'] = $features;

        return $self;
    }

    /**
     * Anthropic's decision on the entity the profile represents: `pending` while it is awaited, `active` once Anthropic has approved the entity for the program, or `rejected` once Anthropic has declined or has removed the entity from the program. `active` does not mean that any one feature is approved: read the feature you need in `features`.
     *
     * @param UserProfileProgramStatus|value-of<UserProfileProgramStatus> $status
     */
    public function withStatus(UserProfileProgramStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
