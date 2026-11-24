<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The control is off and has no keys.
 *
 * @phpstan-import-type BetaGoogleManagedRetiredKeyShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedRetiredKey
 *
 * @phpstan-type BetaGoogleManagedCMEKDisabledShape = array{
 *   retiredKeys: list<BetaGoogleManagedRetiredKey|BetaGoogleManagedRetiredKeyShape>,
 *   type: 'disabled',
 * }
 */
final class BetaGoogleManagedCMEKDisabled implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedCMEKDisabledShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required(type: new ConstantOf('disabled'))]
    public string $type = 'disabled';

    /**
     * Keys that a region has retired, earliest `expires_at` first.
     *
     * @var list<BetaGoogleManagedRetiredKey> $retiredKeys
     */
    #[Required('retired_keys', list: BetaGoogleManagedRetiredKey::class)]
    public array $retiredKeys;

    /**
     * `new BetaGoogleManagedCMEKDisabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedCMEKDisabled::with(retiredKeys: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedCMEKDisabled())->withRetiredKeys(...)
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
     * @param list<BetaGoogleManagedRetiredKey|BetaGoogleManagedRetiredKeyShape> $retiredKeys
     */
    public static function with(array $retiredKeys): self
    {
        $self = new self;

        $self['retiredKeys'] = $retiredKeys;

        return $self;
    }

    /**
     * Keys that a region has retired, earliest `expires_at` first.
     *
     * @param list<BetaGoogleManagedRetiredKey|BetaGoogleManagedRetiredKeyShape> $retiredKeys
     */
    public function withRetiredKeys(array $retiredKeys): self
    {
        $self = clone $this;
        $self['retiredKeys'] = $retiredKeys;

        return $self;
    }

    /**
     * @param 'disabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
