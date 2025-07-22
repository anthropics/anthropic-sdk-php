<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_search_tool_request_error_alias = array{
 *   errorCode: BetaWebSearchToolResultErrorCode::*, type: string
 * }
 */
final class BetaWebSearchToolRequestError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /** @var BetaWebSearchToolResultErrorCode::* $errorCode */
    #[Api('error_code', enum: BetaWebSearchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaWebSearchToolResultErrorCode::* $errorCode
     */
    final public function __construct(string $errorCode)
    {
        self::introspect();

        $this->errorCode = $errorCode;
    }
}
