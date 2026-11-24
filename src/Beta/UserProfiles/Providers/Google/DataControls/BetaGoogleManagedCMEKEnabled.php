<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The control is on and has a key for at least one region.
 *
 * @phpstan-import-type BetaGoogleManagedRetiredKeyShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedRetiredKey
 * @phpstan-import-type BetaGoogleManagedCMEKRegionStatusShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionStatus
 * @phpstan-import-type BetaGoogleManagedCMEKRegionStatusVariants from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionStatus
 *
 * @phpstan-type BetaGoogleManagedCMEKEnabledShape = array{
 *   externalKeyIDs: array<string,string>,
 *   retiredKeys: list<BetaGoogleManagedRetiredKey|BetaGoogleManagedRetiredKeyShape>,
 *   status: array<string,BetaGoogleManagedCMEKRegionStatusShape>,
 *   type: 'enabled',
 * }
 */
final class BetaGoogleManagedCMEKEnabled implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedCMEKEnabledShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * The ID of the External Key configured for each region (`ekey_...`), keyed by region code. A region with no key is left out.
     *
     * @var array<string,string> $externalKeyIDs
     */
    #[Required('external_key_ids', map: 'string')]
    public array $externalKeyIDs;

    /**
     * Keys that a region has retired, earliest `expires_at` first.
     *
     * @var list<BetaGoogleManagedRetiredKey> $retiredKeys
     */
    #[Required('retired_keys', list: BetaGoogleManagedRetiredKey::class)]
    public array $retiredKeys;

    /**
     * Each region's status for the control, keyed by region code. A region that your organization is not offered may have no entry, and Anthropic may add regions.
     *
     * @var array<string,BetaGoogleManagedCMEKRegionStatusVariants> $status
     */
    #[Required(map: BetaGoogleManagedCMEKRegionStatus::class)]
    public array $status;

    /**
     * `new BetaGoogleManagedCMEKEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedCMEKEnabled::with(
     *   externalKeyIDs: ..., retiredKeys: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedCMEKEnabled())
     *   ->withExternalKeyIDs(...)
     *   ->withRetiredKeys(...)
     *   ->withStatus(...)
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
     * @param array<string,string> $externalKeyIDs
     * @param list<BetaGoogleManagedRetiredKey|BetaGoogleManagedRetiredKeyShape> $retiredKeys
     * @param array<string,BetaGoogleManagedCMEKRegionStatusShape> $status
     */
    public static function with(
        array $externalKeyIDs,
        array $retiredKeys,
        array $status
    ): self {
        $self = new self;

        $self['externalKeyIDs'] = $externalKeyIDs;
        $self['retiredKeys'] = $retiredKeys;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The ID of the External Key configured for each region (`ekey_...`), keyed by region code. A region with no key is left out.
     *
     * @param array<string,string> $externalKeyIDs
     */
    public function withExternalKeyIDs(array $externalKeyIDs): self
    {
        $self = clone $this;
        $self['externalKeyIDs'] = $externalKeyIDs;

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
     * Each region's status for the control, keyed by region code. A region that your organization is not offered may have no entry, and Anthropic may add regions.
     *
     * @param array<string,BetaGoogleManagedCMEKRegionStatusShape> $status
     */
    public function withStatus(array $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param 'enabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
