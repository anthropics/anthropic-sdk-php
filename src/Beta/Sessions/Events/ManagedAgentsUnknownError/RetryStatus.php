<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownError;

use Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusExhausted;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusRetrying;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusTerminal;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * What the client should do next in response to this error.
 *
 * @phpstan-import-type ManagedAgentsRetryStatusRetryingShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusRetrying
 * @phpstan-import-type ManagedAgentsRetryStatusExhaustedShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusExhausted
 * @phpstan-import-type ManagedAgentsRetryStatusTerminalShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusTerminal
 *
 * @phpstan-type RetryStatusVariants = ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal
 * @phpstan-type RetryStatusShape = RetryStatusVariants|ManagedAgentsRetryStatusRetryingShape|ManagedAgentsRetryStatusExhaustedShape|ManagedAgentsRetryStatusTerminalShape
 */
final class RetryStatus implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'retrying' => ManagedAgentsRetryStatusRetrying::class,
            'exhausted' => ManagedAgentsRetryStatusExhausted::class,
            'terminal' => ManagedAgentsRetryStatusTerminal::class,
        ];
    }
}
