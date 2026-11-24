<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The configured key passed validation, and the region applies it.
 *
 * @phpstan-type BetaGoogleManagedProjectCMEKRegionActiveShape = array{
 *   effectiveExternalKeyID: string|null,
 *   error: string|null,
 *   lastCheckedAt: \DateTimeInterface|null,
 *   type: 'active',
 *   validatedAt: \DateTimeInterface,
 * }
 */
final class BetaGoogleManagedProjectCMEKRegionActive implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectCMEKRegionActiveShape> */
    use SdkModel;

    /** @var 'active' $type */
    #[Required(type: new ConstantOf('active'))]
    public string $type = 'active';

    /**
     * The ID of the External Key that the region applies now (`ekey_...`). While a replacement key is `pending` or `failed`, this is the previous key. `null` when the region applies no key.
     */
    #[Required('effective_external_key_id')]
    public ?string $effectiveExternalKeyID;

    /**
     * Why Google Cloud KMS refused the region's latest use of the key. `null` when the region has no refusal to report. A `null` does not mean that the key works.
     */
    #[Required]
    public ?string $error;

    /**
     * When the region last got a successful answer from Google Cloud KMS for the key, in RFC 3339 format. `null` when it has none to report.
     */
    #[Required('last_checked_at')]
    public ?\DateTimeInterface $lastCheckedAt;

    /**
     * When the status last became `active`, in RFC 3339 format.
     */
    #[Required('validated_at')]
    public \DateTimeInterface $validatedAt;

    /**
     * `new BetaGoogleManagedProjectCMEKRegionActive()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectCMEKRegionActive::with(
     *   effectiveExternalKeyID: ..., error: ..., lastCheckedAt: ..., validatedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectCMEKRegionActive())
     *   ->withEffectiveExternalKeyID(...)
     *   ->withError(...)
     *   ->withLastCheckedAt(...)
     *   ->withValidatedAt(...)
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
        ?string $effectiveExternalKeyID,
        ?string $error,
        ?\DateTimeInterface $lastCheckedAt,
        \DateTimeInterface $validatedAt,
    ): self {
        $self = new self;

        $self['effectiveExternalKeyID'] = $effectiveExternalKeyID;
        $self['error'] = $error;
        $self['lastCheckedAt'] = $lastCheckedAt;
        $self['validatedAt'] = $validatedAt;

        return $self;
    }

    /**
     * The ID of the External Key that the region applies now (`ekey_...`). While a replacement key is `pending` or `failed`, this is the previous key. `null` when the region applies no key.
     */
    public function withEffectiveExternalKeyID(
        ?string $effectiveExternalKeyID
    ): self {
        $self = clone $this;
        $self['effectiveExternalKeyID'] = $effectiveExternalKeyID;

        return $self;
    }

    /**
     * Why Google Cloud KMS refused the region's latest use of the key. `null` when the region has no refusal to report. A `null` does not mean that the key works.
     */
    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * When the region last got a successful answer from Google Cloud KMS for the key, in RFC 3339 format. `null` when it has none to report.
     */
    public function withLastCheckedAt(?\DateTimeInterface $lastCheckedAt): self
    {
        $self = clone $this;
        $self['lastCheckedAt'] = $lastCheckedAt;

        return $self;
    }

    /**
     * @param 'active' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When the status last became `active`, in RFC 3339 format.
     */
    public function withValidatedAt(\DateTimeInterface $validatedAt): self
    {
        $self = clone $this;
        $self['validatedAt'] = $validatedAt;

        return $self;
    }
}
