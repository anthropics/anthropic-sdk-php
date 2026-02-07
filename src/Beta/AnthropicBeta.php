<?php

declare(strict_types=1);

namespace Anthropic\Beta;

enum AnthropicBeta: string
{
    case MESSAGE_BATCHES_2024_09_24 = 'message-batches-2024-09-24';

    case PROMPT_CACHING_2024_07_31 = 'prompt-caching-2024-07-31';

    case COMPUTER_USE_2024_10_22 = 'computer-use-2024-10-22';

    case COMPUTER_USE_2025_01_24 = 'computer-use-2025-01-24';

    case PDFS_2024_09_25 = 'pdfs-2024-09-25';

    case TOKEN_COUNTING_2024_11_01 = 'token-counting-2024-11-01';

    case TOKEN_EFFICIENT_TOOLS_2025_02_19 = 'token-efficient-tools-2025-02-19';

    case OUTPUT_128K_2025_02_19 = 'output-128k-2025-02-19';

    case FILES_API_2025_04_14 = 'files-api-2025-04-14';

    case MCP_CLIENT_2025_04_04 = 'mcp-client-2025-04-04';

    case MCP_CLIENT_2025_11_20 = 'mcp-client-2025-11-20';

    case DEV_FULL_THINKING_2025_05_14 = 'dev-full-thinking-2025-05-14';

    case INTERLEAVED_THINKING_2025_05_14 = 'interleaved-thinking-2025-05-14';

    case CODE_EXECUTION_2025_05_22 = 'code-execution-2025-05-22';

    case EXTENDED_CACHE_TTL_2025_04_11 = 'extended-cache-ttl-2025-04-11';

    case CONTEXT_1M_2025_08_07 = 'context-1m-2025-08-07';

    case CONTEXT_MANAGEMENT_2025_06_27 = 'context-management-2025-06-27';

    case MODEL_CONTEXT_WINDOW_EXCEEDED_2025_08_26 = 'model-context-window-exceeded-2025-08-26';

    case SKILLS_2025_10_02 = 'skills-2025-10-02';

    case FAST_MODE_2026_02_01 = 'fast-mode-2026-02-01';
}
