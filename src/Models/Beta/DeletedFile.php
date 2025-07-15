<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class DeletedFile implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api(optional: true)]
    public ?string $type = 'file_deleted';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $id, ?string $type = null)
    {
        $this->id = $id;
        $this->type = $type;
    }
}

DeletedFile::_loadMetadata();
