<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebSearchTool20250305;

use Anthropic\Core\Attributes\Api;
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
    #[Api]
    public string $type = 'approximate';

    /**
     * The city of the user.
     */
    #[Api(nullable: true, optional: true)]
    public ?string $city;

    /**
     * The two letter [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) of the user.
     */
    #[Api(nullable: true, optional: true)]
    public ?string $country;

    /**
     * The region of the user.
     */
    #[Api(nullable: true, optional: true)]
    public ?string $region;

    /**
     * The [IANA timezone](https://nodatime.org/TimeZones) of the user.
     */
    #[Api(nullable: true, optional: true)]
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
        $obj = new self;

        null !== $city && $obj['city'] = $city;
        null !== $country && $obj['country'] = $country;
        null !== $region && $obj['region'] = $region;
        null !== $timezone && $obj['timezone'] = $timezone;

        return $obj;
    }

    /**
     * The city of the user.
     */
    public function withCity(?string $city): self
    {
        $obj = clone $this;
        $obj['city'] = $city;

        return $obj;
    }

    /**
     * The two letter [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) of the user.
     */
    public function withCountry(?string $country): self
    {
        $obj = clone $this;
        $obj['country'] = $country;

        return $obj;
    }

    /**
     * The region of the user.
     */
    public function withRegion(?string $region): self
    {
        $obj = clone $this;
        $obj['region'] = $region;

        return $obj;
    }

    /**
     * The [IANA timezone](https://nodatime.org/TimeZones) of the user.
     */
    public function withTimezone(?string $timezone): self
    {
        $obj = clone $this;
        $obj['timezone'] = $timezone;

        return $obj;
    }
}
