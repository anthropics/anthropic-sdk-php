<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class DeletedMessageBatch implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public string $type;

    /**
     * @param string $id
     * @param string $type
     */
    final public function __construct($id, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

DeletedMessageBatch::_loadMetadata();
