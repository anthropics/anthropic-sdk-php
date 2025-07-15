<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\Batches;

use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;

final class DeleteParams implements BaseModel
{
    use Model;
    use Params;

    final public function __construct()
    {
        $this->constructFromArgs(func_get_args());
    }
}

DeleteParams::_loadMetadata();
