<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaWebSearchToolResultError implements BaseModel
{
    use Model;

    #[Api('error_code')]
    public string $errorCode;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string $errorCode `required`
     * @param string $type      `required`
     */
    final public function __construct(
        $errorCode,
        $type = 'web_search_tool_result_error'
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaWebSearchToolResultError::_loadMetadata();
