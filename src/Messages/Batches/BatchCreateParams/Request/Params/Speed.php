<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches\BatchCreateParams\Request\Params;

/**
 * The inference speed mode for this request. `"fast"` enables high output-tokens-per-second inference.
 *
 * Some models require the `fast-mode-2026-02-01` beta header for any `speed` value. See [fast mode](https://platform.claude.com/docs/en/build-with-claude/fast-mode) for which models.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
