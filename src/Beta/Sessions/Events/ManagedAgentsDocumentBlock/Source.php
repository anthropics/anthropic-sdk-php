<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64DocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Source\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource\MediaType;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::BASE64|'base64' ? string|null : MediaType|value-of<MediaType>|null) $mediaType
     *
     * @return ($type is Type::BASE64|'base64' ? ManagedAgentsBase64DocumentSource : ($type is Type::TEXT|'text' ? ManagedAgentsPlainTextDocumentSource : ($type is Type::URL|'url' ? ManagedAgentsURLDocumentSource : ($type is Type::FILE|'file' ? ManagedAgentsFileDocumentSource : ManagedAgentsBase64DocumentSource|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $data = null,
        string|MediaType|null $mediaType = null,
        ?string $url = null,
        ?string $fileID = null,
    ): ManagedAgentsBase64DocumentSource|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource {
        return match ($type) {
            Type::BASE64, 'base64' => ManagedAgentsBase64DocumentSource::with(
                type: 'base64',
                data: $data ?? throw new \ArgumentCountError('$data is required'),
                mediaType: $mediaType ?? throw new \ArgumentCountError('$mediaType is required'),
            ),
            Type::TEXT, 'text' => ManagedAgentsPlainTextDocumentSource::with(
                type: 'text',
                data: $data ?? throw new \ArgumentCountError('$data is required'),
                // @phpstan-ignore argument.type
                mediaType: $mediaType ?? throw new \ArgumentCountError('$mediaType is required'),
            ),
            Type::URL, 'url' => ManagedAgentsURLDocumentSource::with(
                type: 'url',
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::FILE, 'file' => ManagedAgentsFileDocumentSource::with(
                type: 'file',
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
