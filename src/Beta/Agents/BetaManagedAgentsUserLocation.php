<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Approximate user location for search result localization.
 *
 * @phpstan-type BetaManagedAgentsUserLocationShape = array{
 *   type: 'approximate',
 *   city?: string|null,
 *   country?: string|null,
 *   region?: string|null,
 *   timezone?: string|null,
 * }
 */
final class BetaManagedAgentsUserLocation implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsUserLocationShape> */
    use SdkModel;

    /**
     * Location precision. Only "approximate" is supported.
     *
     * @var 'approximate' $type
     */
    #[Required]
    public string $type = 'approximate';

    /**
     * City name.
     */
    #[Optional(nullable: true)]
    public ?string $city;

    /**
     * Two-letter ISO 3166-1 country code, uppercase.
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * Region or state name.
     */
    #[Optional(nullable: true)]
    public ?string $region;

    /**
     * IANA timezone identifier, e.g. "America/Los_Angeles".
     */
    #[Optional(nullable: true)]
    public ?string $timezone;

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
        ?string $city = null,
        ?string $country = null,
        ?string $region = null,
        ?string $timezone = null,
    ): self {
        $self = new self;

        null !== $city && $self['city'] = $city;
        null !== $country && $self['country'] = $country;
        null !== $region && $self['region'] = $region;
        null !== $timezone && $self['timezone'] = $timezone;

        return $self;
    }

    /**
     * Location precision. Only "approximate" is supported.
     *
     * @param 'approximate' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * City name.
     */
    public function withCity(?string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    /**
     * Two-letter ISO 3166-1 country code, uppercase.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Region or state name.
     */
    public function withRegion(?string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    /**
     * IANA timezone identifier, e.g. "America/Los_Angeles".
     */
    public function withTimezone(?string $timezone): self
    {
        $self = clone $this;
        $self['timezone'] = $timezone;

        return $self;
    }
}
