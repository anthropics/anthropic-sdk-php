<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_web_search_tool_result_error_code_alias = BetaWebSearchToolResultErrorCode::*
 */
final class BetaWebSearchToolResultErrorCode implements ConverterSource
{
    use Enum;

    public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    public const UNAVAILABLE = 'unavailable';

    public const MAX_USES_EXCEEDED = 'max_uses_exceeded';

    public const TOO_MANY_REQUESTS = 'too_many_requests';

    public const QUERY_TOO_LONG = 'query_too_long';
}
