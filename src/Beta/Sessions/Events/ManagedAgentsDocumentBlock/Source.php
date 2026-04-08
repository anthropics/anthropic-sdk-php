<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64DocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsURLDocumentSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for document source variants.
 *
 * @phpstan-import-type ManagedAgentsBase64DocumentSourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsBase64DocumentSource
 * @phpstan-import-type ManagedAgentsPlainTextDocumentSourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource
 * @phpstan-import-type ManagedAgentsURLDocumentSourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsURLDocumentSource
 * @phpstan-import-type ManagedAgentsFileDocumentSourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsFileDocumentSource
 *
 * @phpstan-type SourceVariants = ManagedAgentsBase64DocumentSource|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource
 * @phpstan-type SourceShape = SourceVariants|ManagedAgentsBase64DocumentSourceShape|ManagedAgentsPlainTextDocumentSourceShape|ManagedAgentsURLDocumentSourceShape|ManagedAgentsFileDocumentSourceShape
 */
final class Source implements ConverterSource
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
            'base64' => ManagedAgentsBase64DocumentSource::class,
            'text' => ManagedAgentsPlainTextDocumentSource::class,
            'url' => ManagedAgentsURLDocumentSource::class,
            'file' => ManagedAgentsFileDocumentSource::class,
        ];
    }
}
