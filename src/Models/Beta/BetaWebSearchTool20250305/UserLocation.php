<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaWebSearchTool20250305;

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
        $this->city = $city;
        $this->country = $country;
        $this->region = $region;
        $this->timezone = $timezone;
    }
}

UserLocation::_loadMetadata();
