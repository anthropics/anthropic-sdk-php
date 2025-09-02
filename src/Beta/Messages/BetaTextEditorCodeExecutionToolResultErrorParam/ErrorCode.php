<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorParam;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class ErrorCode implements ConverterSource
{
    use SdkEnum;

    public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    public const UNAVAILABLE = 'unavailable';

    public const TOO_MANY_REQUESTS = 'too_many_requests';

    public const EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';

    public const FILE_NOT_FOUND = 'file_not_found';
}
