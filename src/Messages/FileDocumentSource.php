<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type FileDocumentSourceShape = array{fileID: string, type: 'file'}
 */
final class FileDocumentSource implements BaseModel
{
    /** @use SdkModel<FileDocumentSourceShape> */
    use SdkModel;

    /** @var 'file' $type */
    #[Required]
    public string $type = 'file';

    #[Required('file_id')]
    public string $fileID;

    /**
     * `new FileDocumentSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FileDocumentSource::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FileDocumentSource)->withFileID(...)
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
    public static function with(string $fileID): self
    {
        $self = new self;

        $self['fileID'] = $fileID;

        return $self;
    }

    public function withFileID(string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }

    /**
     * @param 'file' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
