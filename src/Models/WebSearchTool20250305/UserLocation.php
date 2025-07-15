<?php

declare(strict_types=1);

namespace Anthropic\Models\WebSearchTool20250305;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class UserLocation implements BaseModel
{
    use Model;

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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $type     `required`
     * @param null|string $city
     * @param null|string $country
     * @param null|string $region
     * @param null|string $timezone
     */
    final public function __construct(
        $type,
        $city = None::NOT_GIVEN,
        $country = None::NOT_GIVEN,
        $region = None::NOT_GIVEN,
        $timezone = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

UserLocation::_loadMetadata();
