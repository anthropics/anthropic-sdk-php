<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaWebSearchTool20250305;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaWebSearchTool20250305\UserLocation\Type;

final class UserLocation implements BaseModel
{
    use Model;

    /** @var Type::* $type */
    #[Api]
    public string $type;

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
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $type,
        ?string $city = null,
        ?string $country = null,
        ?string $region = null,
        ?string $timezone = null,
    ) {
        $this->type = $type;
        $this->city = $city;
        $this->country = $country;
        $this->region = $region;
        $this->timezone = $timezone;
    }
}

UserLocation::_loadMetadata();
