<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCodeExecutionOutputBlockParam implements BaseModel
{
    use Model;

    #[Api('file_id')]
    public string $fileID;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $fileID, string $type)
    {
        $this->fileID = $fileID;
        $this->type = $type;
    }
}

BetaCodeExecutionOutputBlockParam::_loadMetadata();
