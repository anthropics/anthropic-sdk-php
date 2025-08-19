<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
 *
 * @phpstan-type model_alias = Model::*
 */
final class Model implements ConverterSource
{
    use Enum;

    public const CLAUDE_3_7_SONNET_LATEST = 'claude-3-7-sonnet-latest';

    public const CLAUDE_3_7_SONNET_20250219 = 'claude-3-7-sonnet-20250219';

    public const CLAUDE_3_5_HAIKU_LATEST = 'claude-3-5-haiku-latest';

    public const CLAUDE_3_5_HAIKU_20241022 = 'claude-3-5-haiku-20241022';

    public const CLAUDE_SONNET_4_20250514 = 'claude-sonnet-4-20250514';

    public const CLAUDE_SONNET_4_0 = 'claude-sonnet-4-0';

    public const CLAUDE_4_SONNET_20250514 = 'claude-4-sonnet-20250514';

    public const CLAUDE_3_5_SONNET_LATEST = 'claude-3-5-sonnet-latest';

    public const CLAUDE_3_5_SONNET_20241022 = 'claude-3-5-sonnet-20241022';

    public const CLAUDE_3_5_SONNET_20240620 = 'claude-3-5-sonnet-20240620';

    public const CLAUDE_OPUS_4_0 = 'claude-opus-4-0';

    public const CLAUDE_OPUS_4_20250514 = 'claude-opus-4-20250514';

    public const CLAUDE_4_OPUS_20250514 = 'claude-4-opus-20250514';

    public const CLAUDE_OPUS_4_1_20250805 = 'claude-opus-4-1-20250805';

    public const CLAUDE_3_OPUS_LATEST = 'claude-3-opus-latest';

    public const CLAUDE_3_OPUS_20240229 = 'claude-3-opus-20240229';

    public const CLAUDE_3_HAIKU_20240307 = 'claude-3-haiku-20240307';
}
