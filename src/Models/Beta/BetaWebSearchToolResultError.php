<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaWebSearchToolResultError\Type;

final class BetaWebSearchToolResultError implements BaseModel
{
    use Model;

    /** @var BetaWebSearchToolResultErrorCode::* $errorCode */
    #[Api('error_code')]
    public string $errorCode;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'web_search_tool_result_error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaWebSearchToolResultErrorCode::* $errorCode
     * @param Type::*                             $type
     */
    final public function __construct(
        string $errorCode,
        string $type = 'web_search_tool_result_error'
    ) {
        $this->errorCode = $errorCode;
        $this->type = $type;
    }
}

BetaWebSearchToolResultError::_loadMetadata();
