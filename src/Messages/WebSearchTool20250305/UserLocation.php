<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebSearchTool20250305;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for the user's location. Used to provide more relevant search results.
 *
 * @phpstan-type user_location_alias = array{
 *   type: string,
 *   city?: string|null,
 *   country?: string|null,
 *   region?: string|null,
 *   timezone?: string|null,
 * }
 */
final class UserLocation implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'approximate';

    /**
     * The city of the user.
     */
    #[Api(optional: true)]
    public ?string $city;

    /**
     * The two letter [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) of the user.
     */
    #[Api(optional: true)]
    public ?string $country;

    /**
     * The region of the user.
     */
    #[Api(optional: true)]
    public ?string $region;

    /**
     * The [IANA timezone](https://nodatime.org/TimeZones) of the user.
     */
    #[Api(optional: true)]
    public ?string $timezone;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        ?string $city = null,
        ?string $country = null,
        ?string $region = null,
        ?string $timezone = null,
    ): self {
        $obj = new self;

        null !== $city && $obj->city = $city;
        null !== $country && $obj->country = $country;
        null !== $region && $obj->region = $region;
        null !== $timezone && $obj->timezone = $timezone;

        return $obj;
    }

    /**
     * The city of the user.
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * The two letter [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) of the user.
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * The region of the user.
     */
    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * The [IANA timezone](https://nodatime.org/TimeZones) of the user.
     */
    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }
}
