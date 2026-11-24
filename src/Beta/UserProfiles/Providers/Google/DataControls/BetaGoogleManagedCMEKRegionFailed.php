<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The region stopped retrying validation before the configured key passed. To restart validation, send the region a key again. It can be the same key.
 *
 * @phpstan-type BetaGoogleManagedCMEKRegionFailedShape = array{
 *   effectiveExternalKeyID: string|null, error: string, type: 'failed'
 * }
 */
final class BetaGoogleManagedCMEKRegionFailed implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedCMEKRegionFailedShape> */
    use SdkModel;

    /** @var 'failed' $type */
    #[Required(type: new ConstantOf('failed'))]
    public string $type = 'failed';

    /**
     * The ID of the External Key that the region applies now (`ekey_...`). While a replacement key is `pending` or `failed`, this is the previous key. `null` when the region applies no key.
     */
    #[Required('effective_external_key_id')]
    public ?string $effectiveExternalKeyID;

    /**
     * Why the region cannot use the configured key.
     */
    #[Required]
    public string $error;

    /**
     * `new BetaGoogleManagedCMEKRegionFailed()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedCMEKRegionFailed::with(effectiveExternalKeyID: ..., error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedCMEKRegionFailed())
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
        string $error
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
     * Why the region cannot use the configured key.
     */
    public function withError(string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * @param 'failed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
