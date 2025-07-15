<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\Batches;

use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;

final class RetrieveParams implements BaseModel
{
    use Model;
    use Params;

    final public function __construct() {}
}

RetrieveParams::_loadMetadata();
