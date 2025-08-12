<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebSearchToolResultError;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type error_code_alias = ErrorCode::*
 */
final class ErrorCode implements ConverterSource
{
    use Enum;

    public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    public const UNAVAILABLE = 'unavailable';

    public const MAX_USES_EXCEEDED = 'max_uses_exceeded';

    public const TOO_MANY_REQUESTS = 'too_many_requests';

    public const QUERY_TOO_LONG = 'query_too_long';
}
