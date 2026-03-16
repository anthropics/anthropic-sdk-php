<?php

declare(strict_types=1);

namespace Anthropic\Messages\ThinkingConfigEnabled;

/**
 * Controls how thinking content appears in the response. When set to `summarized`, thinking is returned normally. When set to `omitted`, thinking content is redacted but a signature is returned for multi-turn continuity. Defaults to `summarized`.
 */
enum Display: string
{
    case SUMMARIZED = 'summarized';

    case OMITTED = 'omitted';
}
