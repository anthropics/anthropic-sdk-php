<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has withdrawn or paused its approval of customer-managed keys for this project, so the region does not apply the control.
 *
 * @phpstan-type BetaGoogleManagedProjectCMEKRegionSuspendedShape = array{
 *   effectiveExternalKeyID: string|null, type: 'suspended'
 * }
 */
final class BetaGoogleManagedProjectCMEKRegionSuspended implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectCMEKRegionSuspendedShape> */
    use SdkModel;

    /** @var 'suspended' $type */
    #[Required(type: new ConstantOf('suspended'))]
    public string $type = 'suspended';

    /**
     * The ID of the External Key that the region applies now (`ekey_...`). While a replacement key is `pending` or `failed`, this is the previous key. `null` when the region applies no key.
     */
    #[Required('effective_external_key_id')]
    public ?string $effectiveExternalKeyID;

    /**
     * `new BetaGoogleManagedProjectCMEKRegionSuspended()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectCMEKRegionSuspended::with(effectiveExternalKeyID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectCMEKRegionSuspended())
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
     * @param 'suspended' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
