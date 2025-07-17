<?php

declare(strict_types=1);

namespace Anthropic\Models\WebSearchTool20250305;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class UserLocation implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'approximate';

    #[Api(optional: true)]
    public ?string $city;

    #[Api(optional: true)]
    public ?string $country;

    #[Api(optional: true)]
    public ?string $region;

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
