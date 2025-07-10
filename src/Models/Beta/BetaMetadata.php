<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaMetadata implements BaseModel
{
    use Model;

    #[Api('user_id', optional: true)]
    public ?string $userID;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param null|string $userID
     */
    final public function __construct($userID = None::NOT_GIVEN)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMetadata::_loadMetadata();
