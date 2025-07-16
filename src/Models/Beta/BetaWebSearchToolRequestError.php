<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaWebSearchToolRequestError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /** @var BetaWebSearchToolResultErrorCode::* $errorCode */
    #[Api('error_code')]
    public string $errorCode;

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaWebSearchToolResultErrorCode::* $errorCode
     */
    final public function __construct(string $errorCode)
    {
        $this->errorCode = $errorCode;

        self::_introspect();
    }
}
