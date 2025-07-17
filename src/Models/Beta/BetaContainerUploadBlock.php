<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaContainerUploadBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'container_upload';

    #[Api('file_id')]
    public string $fileID;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $fileID)
    {
        self::introspect();

        $this->fileID = $fileID;
    }
}
