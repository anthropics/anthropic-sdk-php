<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class CitationsConfigParam implements BaseModel
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

CitationsConfigParam::_loadMetadata();
