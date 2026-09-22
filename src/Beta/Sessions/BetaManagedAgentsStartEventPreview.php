<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

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
}
