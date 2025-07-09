<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class DeletedFile implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api(optional: true)]
    public ?string $type;

    /**
     * @param string      $id
     * @param null|string $type
     */
    final public function __construct($id, $type = None::NOT_GIVEN)
    {
        $this->constructFromArgs(func_get_args());
    }
}

DeletedFile::_loadMetadata();
