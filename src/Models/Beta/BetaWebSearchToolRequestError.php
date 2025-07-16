<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaWebSearchToolRequestError\Type;

final class BetaWebSearchToolRequestError implements BaseModel
{
    use Model;

    /** @var BetaWebSearchToolResultErrorCode::* $errorCode */
    #[Api('error_code')]
    public string $errorCode;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaWebSearchToolResultErrorCode::* $errorCode
     * @param Type::*                             $type
     */
    final public function __construct(string $errorCode, string $type)
    {
        $this->errorCode = $errorCode;
        $this->type = $type;
    }
}

BetaWebSearchToolRequestError::_loadMetadata();
