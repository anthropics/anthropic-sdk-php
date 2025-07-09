<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaCitationsConfigParam implements BaseModel
{
    use Model;

    #[Api(optional: true)]
    public ?bool $enabled;

    /** @param null|bool $enabled */
    final public function __construct($enabled = None::NOT_GIVEN)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCitationsConfigParam::_loadMetadata();
