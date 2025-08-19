<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type anthropic_beta_alias = AnthropicBeta::*
 */
final class AnthropicBeta implements ConverterSource
{
    use Enum;

    public const MESSAGE_BATCHES_2024_09_24 = 'message-batches-2024-09-24';

    public const PROMPT_CACHING_2024_07_31 = 'prompt-caching-2024-07-31';

    public const COMPUTER_USE_2024_10_22 = 'computer-use-2024-10-22';

    public const COMPUTER_USE_2025_01_24 = 'computer-use-2025-01-24';

    public const PDFS_2024_09_25 = 'pdfs-2024-09-25';

    public const TOKEN_COUNTING_2024_11_01 = 'token-counting-2024-11-01';

    public const TOKEN_EFFICIENT_TOOLS_2025_02_19 = 'token-efficient-tools-2025-02-19';

    public const OUTPUT_128K_2025_02_19 = 'output-128k-2025-02-19';

    public const FILES_API_2025_04_14 = 'files-api-2025-04-14';

    public const MCP_CLIENT_2025_04_04 = 'mcp-client-2025-04-04';

    public const DEV_FULL_THINKING_2025_05_14 = 'dev-full-thinking-2025-05-14';

    public const INTERLEAVED_THINKING_2025_05_14 = 'interleaved-thinking-2025-05-14';

    public const CODE_EXECUTION_2025_05_22 = 'code-execution-2025-05-22';

    public const EXTENDED_CACHE_TTL_2025_04_11 = 'extended-cache-ttl-2025-04-11';

    public const CONTEXT_1M_2025_08_07 = 'context-1m-2025-08-07';
}
