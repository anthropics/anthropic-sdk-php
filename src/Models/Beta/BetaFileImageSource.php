<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaFileImageSource\Type;

final class BetaFileImageSource implements BaseModel
{
    use Model;

    #[Api('file_id')]
    public string $fileID;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(string $fileID, string $type)
    {
        $this->fileID = $fileID;
        $this->type = $type;
    }
}

BetaFileImageSource::_loadMetadata();
