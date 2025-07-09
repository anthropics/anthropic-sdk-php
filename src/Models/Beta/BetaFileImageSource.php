<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaFileImageSource implements BaseModel
{
    use Model;

    #[Api('file_id')]
    public string $fileID;

    #[Api]
    public string $type;

    /**
     * @param string $fileID
     * @param string $type
     */
    final public function __construct($fileID, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaFileImageSource::_loadMetadata();
