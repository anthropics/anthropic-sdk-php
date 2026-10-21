<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Plain text document content.
 *
 * @phpstan-type ManagedAgentsPlainTextDocumentSourceShape = array{
 *   data: string, mediaType: 'text/plain', type: 'text'
 * }
 */
final class ManagedAgentsPlainTextDocumentSource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsPlainTextDocumentSourceShape> */
    use SdkModel;

    /**
     * MIME type of the text content. Must be "text/plain".
     *
     * @var 'text/plain' $mediaType
     */
    #[Required('media_type', type: new ConstantOf('text/plain'))]
    public string $mediaType = 'text/plain';

    /** @var 'text' $type */
    #[Required(type: new ConstantOf('text'))]
    public string $type = 'text';

    /**
     * The plain text content.
     */
    #[Required]
    public string $data;

    /**
     * `new ManagedAgentsPlainTextDocumentSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsPlainTextDocumentSource::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsPlainTextDocumentSource())->withData(...)
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
     */
    public static function with(string $data): self
    {
        $self = new self;

        $self['data'] = $data;

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
     * @param 'text/plain' $mediaType
     */
    public function withMediaType(string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * @param 'text' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
