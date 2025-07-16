<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCodeExecutionOutputBlock\Type;

final class BetaCodeExecutionOutputBlock implements BaseModel
{
    use Model;

    #[Api('file_id')]
    public string $fileID;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'code_execution_output';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $fileID,
        string $type = 'code_execution_output'
    ) {
        $this->fileID = $fileID;
        $this->type = $type;
    }
}

BetaCodeExecutionOutputBlock::_loadMetadata();
