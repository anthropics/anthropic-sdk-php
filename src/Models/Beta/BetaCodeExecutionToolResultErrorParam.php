<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCodeExecutionToolResultErrorParam implements BaseModel
{
    use Model;

    #[Api('error_code')]
    public string $errorCode;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $errorCode, string $type)
    {
        $this->errorCode = $errorCode;
        $this->type = $type;
    }
}

BetaCodeExecutionToolResultErrorParam::_loadMetadata();
