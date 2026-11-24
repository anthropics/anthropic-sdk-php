<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Core\Conversion\MapOf;

/**
 * Turns the control on, or changes its keys while it is on.
 *
 * @phpstan-type BetaGoogleManagedCMEKEnabledParamsShape = array{
 *   type: 'enabled', externalKeyIDs?: array<string,string|null>|null
 * }
 */
final class BetaGoogleManagedCMEKEnabledParams implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedCMEKEnabledParamsShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * The External Key to use in each region, keyed by region code, such as `us` or `eu`. An External Key ID (`ekey_...`) sets that region's key, `null` removes it, and a region you leave out keeps its key. While the control is on, at least one region must have a key.
     *
     * @var array<string,string|null>|null $externalKeyIDs
     */
    #[Optional(
        'external_key_ids',
        type: new MapOf('string', nullable: true),
        nullable: true,
    )]
    public ?array $externalKeyIDs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string|null>|null $externalKeyIDs
     */
    public static function with(?array $externalKeyIDs = null): self
    {
        $self = new self;

        null !== $externalKeyIDs && $self['externalKeyIDs'] = $externalKeyIDs;

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

    /**
     * The External Key to use in each region, keyed by region code, such as `us` or `eu`. An External Key ID (`ekey_...`) sets that region's key, `null` removes it, and a region you leave out keeps its key. While the control is on, at least one region must have a key.
     *
     * @param array<string,string|null>|null $externalKeyIDs
     */
    public function withExternalKeyIDs(?array $externalKeyIDs): self
    {
        $self = clone $this;
        $self['externalKeyIDs'] = $externalKeyIDs;

        return $self;
    }
}
