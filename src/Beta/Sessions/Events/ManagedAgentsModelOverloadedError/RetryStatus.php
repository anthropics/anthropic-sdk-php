<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError;

use Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError\RetryStatus\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::RETRYING|'retrying' ? ManagedAgentsRetryStatusRetrying : ($type is Type::EXHAUSTED|'exhausted' ? ManagedAgentsRetryStatusExhausted : ($type is Type::TERMINAL|'terminal' ? ManagedAgentsRetryStatusTerminal : ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
    ): ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal {
        return match ($type) {
            Type::RETRYING, 'retrying' => ManagedAgentsRetryStatusRetrying::with(
                type: 'retrying'
            ),
            Type::EXHAUSTED, 'exhausted' => ManagedAgentsRetryStatusExhausted::with(
                type: 'exhausted'
            ),
            Type::TERMINAL, 'terminal' => ManagedAgentsRetryStatusTerminal::with(
                type: 'terminal'
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
