<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolResultEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Content block in a tool result. Can be `text`, `image`, `document`, or `search_result`.
 *
 * @phpstan-import-type ManagedAgentsTextBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock
 * @phpstan-import-type ManagedAgentsImageBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock
 * @phpstan-import-type ManagedAgentsDocumentBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock
 *
 * @phpstan-type ContentVariants = ManagedAgentsTextBlock|ManagedAgentsImageBlock|ManagedAgentsDocumentBlock
 * @phpstan-type ContentShape = ContentVariants|ManagedAgentsTextBlockShape|ManagedAgentsImageBlockShape|ManagedAgentsDocumentBlockShape
 */
final class Content implements ConverterSource
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
            'text' => ManagedAgentsTextBlock::class,
            'image' => ManagedAgentsImageBlock::class,
            'document' => ManagedAgentsDocumentBlock::class,
        ];
    }
}
