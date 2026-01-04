<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type FileMetadataShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   filename: string,
 *   mimeType: string,
 *   sizeBytes: int,
 *   type: 'file',
 *   downloadable?: bool|null,
 * }
 */
final class FileMetadata implements BaseModel
{
    /** @use SdkModel<FileMetadataShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For files, this is always `"file"`.
     *
     * @var 'file' $type
     */
    #[Required]
    public string $type = 'file';

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string representing when the file was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Original filename of the uploaded file.
     */
    #[Required]
    public string $filename;

    /**
     * MIME type of the file.
     */
    #[Required('mime_type')]
    public string $mimeType;

    /**
     * Size of the file in bytes.
     */
    #[Required('size_bytes')]
    public int $sizeBytes;

    /**
     * Whether the file can be downloaded.
     */
    #[Optional]
    public ?bool $downloadable;

    /**
     * `new FileMetadata()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FileMetadata::with(
     *   id: ..., createdAt: ..., filename: ..., mimeType: ..., sizeBytes: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FileMetadata)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withFilename(...)
     *   ->withMimeType(...)
     *   ->withSizeBytes(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $filename,
        string $mimeType,
        int $sizeBytes,
        ?bool $downloadable = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['filename'] = $filename;
        $self['mimeType'] = $mimeType;
        $self['sizeBytes'] = $sizeBytes;

        null !== $downloadable && $self['downloadable'] = $downloadable;

        return $self;
    }

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string representing when the file was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Original filename of the uploaded file.
     */
    public function withFilename(string $filename): self
    {
        $self = clone $this;
        $self['filename'] = $filename;

        return $self;
    }

    /**
     * MIME type of the file.
     */
    public function withMimeType(string $mimeType): self
    {
        $self = clone $this;
        $self['mimeType'] = $mimeType;

        return $self;
    }

    /**
     * Size of the file in bytes.
     */
    public function withSizeBytes(int $sizeBytes): self
    {
        $self = clone $this;
        $self['sizeBytes'] = $sizeBytes;

        return $self;
    }

    /**
     * Whether the file can be downloaded.
     */
    public function withDownloadable(bool $downloadable): self
    {
        $self = clone $this;
        $self['downloadable'] = $downloadable;

        return $self;
    }
}
