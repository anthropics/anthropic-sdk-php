<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Base64-encoded document data.
 *
 * @phpstan-type ManagedAgentsBase64DocumentSourceShape = array{
 *   data: string, mediaType: string, type: 'base64'
 * }
 */
final class ManagedAgentsBase64DocumentSource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsBase64DocumentSourceShape> */
    use SdkModel;

    /** @var 'base64' $type */
    #[Required(type: new ConstantOf('base64'))]
    public string $type = 'base64';

    /**
     * Base64-encoded document data.
     */
    #[Required]
    public string $data;

    /**
     * MIME type of the document (e.g., "application/pdf").
     */
    #[Required('media_type')]
    public string $mediaType;

    /**
     * `new ManagedAgentsBase64DocumentSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsBase64DocumentSource::with(data: ..., mediaType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsBase64DocumentSource())->withData(...)->withMediaType(...)
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
    public static function with(string $data, string $mediaType): self
    {
        $self = new self;

        $self['data'] = $data;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Base64-encoded document data.
     */
    public function withData(string $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * MIME type of the document (e.g., "application/pdf").
     */
    public function withMediaType(string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * @param 'base64' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
