<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_code_execution_tool_result_error_code_alias = BetaCodeExecutionToolResultErrorCode::*
 */
final class BetaCodeExecutionToolResultErrorCode implements ConverterSource
{
    use Enum;

    public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    public const UNAVAILABLE = 'unavailable';

    public const TOO_MANY_REQUESTS = 'too_many_requests';

    public const EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';
}
