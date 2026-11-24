<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A key that a region has retired. Keep the key usable until `expires_at`.
 *
 * @phpstan-type BetaGoogleManagedRetiredKeyShape = array{
 *   expiresAt: \DateTimeInterface, externalKeyID: string, region: string
 * }
 */
final class BetaGoogleManagedRetiredKey implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedRetiredKeyShape> */
    use SdkModel;

    /**
     * When this entry is removed, in RFC 3339 format.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * The ID of the retired External Key (`ekey_...`).
     */
    #[Required('external_key_id')]
    public string $externalKeyID;

    /**
     * The code of the region that retired the key.
     */
    #[Required]
    public string $region;

    /**
     * `new BetaGoogleManagedRetiredKey()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedRetiredKey::with(
     *   expiresAt: ..., externalKeyID: ..., region: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedRetiredKey())
     *   ->withExpiresAt(...)
     *   ->withExternalKeyID(...)
     *   ->withRegion(...)
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
     */
    public static function with(
        \DateTimeInterface $expiresAt,
        string $externalKeyID,
        string $region
    ): self {
        $self = new self;

        $self['expiresAt'] = $expiresAt;
        $self['externalKeyID'] = $externalKeyID;
        $self['region'] = $region;

        return $self;
    }

    /**
     * When this entry is removed, in RFC 3339 format.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * The ID of the retired External Key (`ekey_...`).
     */
    public function withExternalKeyID(string $externalKeyID): self
    {
        $self = clone $this;
        $self['externalKeyID'] = $externalKeyID;

        return $self;
    }

    /**
     * The code of the region that retired the key.
     */
    public function withRegion(string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }
}
