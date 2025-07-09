<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class Metadata implements BaseModel
{
    use Model;

    #[Api('user_id', optional: true)]
    public ?string $userID;

    /** @param null|string $userID */
    final public function __construct($userID = None::NOT_GIVEN)
    {
        $this->constructFromArgs(func_get_args());
    }
}

Metadata::_loadMetadata();
