<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The control is off and has no keys.
 *
 * @phpstan-import-type BetaGoogleManagedProjectRetiredKeyShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectRetiredKey
 *
 * @phpstan-type BetaGoogleManagedProjectCMEKDisabledShape = array{
 *   retiredKeys: list<BetaGoogleManagedProjectRetiredKey|BetaGoogleManagedProjectRetiredKeyShape>,
 *   type: 'disabled',
 * }
 */
final class BetaGoogleManagedProjectCMEKDisabled implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectCMEKDisabledShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required(type: new ConstantOf('disabled'))]
    public string $type = 'disabled';

    /**
     * Keys that a region has retired, earliest `expires_at` first.
     *
     * @var list<BetaGoogleManagedProjectRetiredKey> $retiredKeys
     */
    #[Required('retired_keys', list: BetaGoogleManagedProjectRetiredKey::class)]
    public array $retiredKeys;

    /**
     * `new BetaGoogleManagedProjectCMEKDisabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectCMEKDisabled::with(retiredKeys: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectCMEKDisabled())->withRetiredKeys(...)
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
     * @param list<BetaGoogleManagedProjectRetiredKey|BetaGoogleManagedProjectRetiredKeyShape> $retiredKeys
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
     * @param list<BetaGoogleManagedProjectRetiredKey|BetaGoogleManagedProjectRetiredKeyShape> $retiredKeys
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
