<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\Batches;

use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;

class DeleteParams implements BaseModel
{
    use Model;
    use Params;
}

DeleteParams::_loadMetadata();
