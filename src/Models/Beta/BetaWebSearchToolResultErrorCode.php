<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_web_search_tool_result_error_code_alias = BetaWebSearchToolResultErrorCode::*
 */
final class BetaWebSearchToolResultErrorCode implements ConverterSource
{
    use Enum;

    final public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    final public const UNAVAILABLE = 'unavailable';

    final public const MAX_USES_EXCEEDED = 'max_uses_exceeded';

    final public const TOO_MANY_REQUESTS = 'too_many_requests';

    final public const QUERY_TOO_LONG = 'query_too_long';
}
