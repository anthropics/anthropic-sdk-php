<?php

declare(strict_types=1);

namespace Anthropic\Messages\ThinkingConfigAdaptive;

/**
 * Controls how thinking content appears in the response. When set to `summarized`, thinking is returned normally. When set to `omitted`, thinking content is redacted but a signature is returned for multi-turn continuity. The default depends on the model; see [Controlling thinking display](https://platform.claude.com/docs/en/build-with-claude/thinking#controlling-thinking-display).
 */
enum Display: string
{
    case SUMMARIZED = 'summarized';

    case OMITTED = 'omitted';
}
