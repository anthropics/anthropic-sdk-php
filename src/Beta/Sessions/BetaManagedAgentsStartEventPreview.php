<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsStartEventPreview\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaManagedAgentsAgentMessagePreviewShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentMessagePreview
 * @phpstan-import-type BetaManagedAgentsAgentThinkingPreviewShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentThinkingPreview
 *
 * @phpstan-type BetaManagedAgentsStartEventPreviewVariants = BetaManagedAgentsAgentMessagePreview|BetaManagedAgentsAgentThinkingPreview
 * @phpstan-type BetaManagedAgentsStartEventPreviewShape = BetaManagedAgentsStartEventPreviewVariants|BetaManagedAgentsAgentMessagePreviewShape|BetaManagedAgentsAgentThinkingPreviewShape
 */
final class BetaManagedAgentsStartEventPreview implements ConverterSource
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
            'agent.message' => BetaManagedAgentsAgentMessagePreview::class,
            'agent.thinking' => BetaManagedAgentsAgentThinkingPreview::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AGENT_MESSAGE|'agent.message' ? BetaManagedAgentsAgentMessagePreview : ($type is Type::AGENT_THINKING|'agent.thinking' ? BetaManagedAgentsAgentThinkingPreview : BetaManagedAgentsAgentMessagePreview|BetaManagedAgentsAgentThinkingPreview))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $id
    ): BetaManagedAgentsAgentMessagePreview|BetaManagedAgentsAgentThinkingPreview {
        return match ($type) {
            Type::AGENT_MESSAGE, 'agent.message' => BetaManagedAgentsAgentMessagePreview::with(
                type: 'agent.message',
                id: $id
            ),
            Type::AGENT_THINKING, 'agent.thinking' => BetaManagedAgentsAgentThinkingPreview::with(
                type: 'agent.thinking',
                id: $id
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
