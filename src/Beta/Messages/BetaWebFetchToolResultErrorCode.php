<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class BetaWebFetchToolResultErrorCode implements ConverterSource
{
    use SdkEnum;

    public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    public const URL_TOO_LONG = 'url_too_long';

    public const URL_NOT_ALLOWED = 'url_not_allowed';

    public const URL_NOT_ACCESSIBLE = 'url_not_accessible';

    public const UNSUPPORTED_CONTENT_TYPE = 'unsupported_content_type';

    public const TOO_MANY_REQUESTS = 'too_many_requests';

    public const MAX_USES_EXCEEDED = 'max_uses_exceeded';

    public const UNAVAILABLE = 'unavailable';
}
