<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The region is validating the configured key, or the key has passed validation and the region has not started to apply it.
 *
 * @phpstan-type BetaGoogleManagedProjectCMEKRegionPendingShape = array{
 *   effectiveExternalKeyID: string|null, error: string|null, type: 'pending'
 * }
 */
final class BetaGoogleManagedProjectCMEKRegionPending implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectCMEKRegionPendingShape> */
    use SdkModel;

    /** @var 'pending' $type */
    #[Required(type: new ConstantOf('pending'))]
    public string $type = 'pending';

    /**
     * The ID of the External Key that the region applies now (`ekey_...`). While a replacement key is `pending` or `failed`, this is the previous key. `null` when the region applies no key.
     */
    #[Required('effective_external_key_id')]
    public ?string $effectiveExternalKeyID;

    /**
     * Why the latest validation attempt failed. `null` when no attempt has failed.
     */
    #[Required]
    public ?string $error;

    /**
     * `new BetaGoogleManagedProjectCMEKRegionPending()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectCMEKRegionPending::with(
     *   effectiveExternalKeyID: ..., error: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectCMEKRegionPending())
     *   ->withEffectiveExternalKeyID(...)
     *   ->withError(...)
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
        ?string $error
    ): self {
        $self = new self;

        $self['effectiveExternalKeyID'] = $effectiveExternalKeyID;
        $self['error'] = $error;

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
     * Why the latest validation attempt failed. `null` when no attempt has failed.
     */
    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * @param 'pending' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
