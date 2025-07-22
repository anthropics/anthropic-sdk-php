<?php

declare(strict_types=1);

namespace Anthropic\Models\WebSearchTool20250305;

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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        ?string $city = null,
        ?string $country = null,
        ?string $region = null,
        ?string $timezone = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $city && $this->city = $city;
        null !== $country && $this->country = $country;
        null !== $region && $this->region = $region;
        null !== $timezone && $this->timezone = $timezone;
    }
}
