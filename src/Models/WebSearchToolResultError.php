<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class WebSearchToolResultError implements BaseModel
{
    use Model;

    #[Api('error_code')]
    public string $errorCode;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $errorCode,
        string $type = 'web_search_tool_result_error'
    ) {
        $this->errorCode = $errorCode;
        $this->type = $type;
    }
}

WebSearchToolResultError::_loadMetadata();
