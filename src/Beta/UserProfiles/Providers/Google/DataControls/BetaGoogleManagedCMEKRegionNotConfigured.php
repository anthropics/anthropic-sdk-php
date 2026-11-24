<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No key is set for this region.
 *
 * @phpstan-type BetaGoogleManagedCMEKRegionNotConfiguredShape = array{
 *   effectiveExternalKeyID: string|null, type: 'not_configured'
 * }
 */
final class BetaGoogleManagedCMEKRegionNotConfigured implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedCMEKRegionNotConfiguredShape> */
    use SdkModel;

    /** @var 'not_configured' $type */
    #[Required(type: new ConstantOf('not_configured'))]
    public string $type = 'not_configured';

    /**
     * The ID of the External Key that the region applies now (`ekey_...`). While a replacement key is `pending` or `failed`, this is the previous key. `null` when the region applies no key.
     */
    #[Required('effective_external_key_id')]
    public ?string $effectiveExternalKeyID;

    /**
     * `new BetaGoogleManagedCMEKRegionNotConfigured()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedCMEKRegionNotConfigured::with(effectiveExternalKeyID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedCMEKRegionNotConfigured())
     *   ->withEffectiveExternalKeyID(...)
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
    public static function with(?string $effectiveExternalKeyID): self
    {
        $self = new self;

        $self['effectiveExternalKeyID'] = $effectiveExternalKeyID;

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
     * @param 'not_configured' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
