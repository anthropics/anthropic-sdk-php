<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;

class ListParams implements BaseModel
{
    use Model;
    use Params;

    #[Api(optional: true)]
    public string $afterID;

    #[Api(optional: true)]
    public string $beforeID;

    #[Api(optional: true)]
    public int $limit;
}

ListParams::_loadMetadata();
