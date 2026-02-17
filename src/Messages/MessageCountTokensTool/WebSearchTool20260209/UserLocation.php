<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageCountTokensTool\WebSearchTool20260209;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for the user's location. Used to provide more relevant search results.
 *
 * @phpstan-type UserLocationShape = array{
 *   type: 'approximate',
 *   city?: string|null,
 *   country?: string|null,
 *   region?: string|null,
 *   timezone?: string|null,
 * }
 */
final class UserLocation implements BaseModel
{
    /** @use SdkModel<UserLocationShape> */
    use SdkModel;

    /** @var 'approximate' $type */
    #[Required]
    public string $type = 'approximate';

    /**
     * The city of the user.
     */
    #[Optional(nullable: true)]
    public ?string $city;

    /**
     * The two letter [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) of the user.
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * The region of the user.
     */
    #[Optional(nullable: true)]
    public ?string $region;

    /**
     * The [IANA timezone](https://nodatime.org/TimeZones) of the user.
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
     * @param 'approximate' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The city of the user.
     */
    public function withCity(?string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    /**
     * The two letter [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) of the user.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * The region of the user.
     */
    public function withRegion(?string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    /**
     * The [IANA timezone](https://nodatime.org/TimeZones) of the user.
     */
    public function withTimezone(?string $timezone): self
    {
        $self = clone $this;
        $self['timezone'] = $timezone;

        return $self;
    }
}
