<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaFileImageSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'file';

    #[Api('file_id')]
    public string $fileID;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $fileID)
    {
        $this->fileID = $fileID;

        self::_introspect();
    }
}
