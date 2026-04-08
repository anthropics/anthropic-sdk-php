<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource\MediaType;
use Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Plain text document content.
 *
 * @phpstan-type ManagedAgentsPlainTextDocumentSourceShape = array{
 *   data: string,
 *   mediaType: MediaType|value-of<MediaType>,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsPlainTextDocumentSource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsPlainTextDocumentSourceShape> */
    use SdkModel;

    /**
     * The plain text content.
     */
    #[Required]
    public string $data;

    /**
     * MIME type of the text content. Must be "text/plain".
     *
     * @var value-of<MediaType> $mediaType
     */
    #[Required('media_type', enum: MediaType::class)]
    public string $mediaType;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsPlainTextDocumentSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsPlainTextDocumentSource::with(data: ..., mediaType: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsPlainTextDocumentSource)
     *   ->withData(...)
     *   ->withMediaType(...)
     *   ->withType(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MediaType|value-of<MediaType> $mediaType
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $data,
        MediaType|string $mediaType,
        Type|string $type
    ): self {
        $self = new self;

        $self['data'] = $data;
        $self['mediaType'] = $mediaType;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The plain text content.
     */
    public function withData(string $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * MIME type of the text content. Must be "text/plain".
     *
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
