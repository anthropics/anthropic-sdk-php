<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type FileMetadataShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   filename: string,
 *   mimeType: string,
 *   sizeBytes: int,
 *   type: string,
 *   downloadable?: bool,
 * }
 */
final class FileMetadata implements BaseModel, ResponseConverter
{
    /** @use SdkModel<FileMetadataShape> */
    use SdkModel;

    use SdkResponse;

    /**
     * Object type.
     *
     * For files, this is always `"file"`.
     */
    #[Api]
    public string $type = 'file';

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    #[Api]
    public string $id;

    /**
     * RFC 3339 datetime string representing when the file was created.
     */
    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Original filename of the uploaded file.
     */
    #[Api]
    public string $filename;

    /**
     * MIME type of the file.
     */
    #[Api('mime_type')]
    public string $mimeType;

    /**
     * Size of the file in bytes.
     */
    #[Api('size_bytes')]
    public int $sizeBytes;

    /**
     * Whether the file can be downloaded.
     */
    #[Api(optional: true)]
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
        $obj = new self;

        $obj->id = $id;
        $obj->createdAt = $createdAt;
        $obj->filename = $filename;
        $obj->mimeType = $mimeType;
        $obj->sizeBytes = $sizeBytes;

        null !== $downloadable && $obj->downloadable = $downloadable;

        return $obj;
    }

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing when the file was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $obj = clone $this;
        $obj->createdAt = $createdAt;

        return $obj;
    }

    /**
     * Original filename of the uploaded file.
     */
    public function withFilename(string $filename): self
    {
        $obj = clone $this;
        $obj->filename = $filename;

        return $obj;
    }

    /**
     * MIME type of the file.
     */
    public function withMimeType(string $mimeType): self
    {
        $obj = clone $this;
        $obj->mimeType = $mimeType;

        return $obj;
    }

    /**
     * Size of the file in bytes.
     */
    public function withSizeBytes(int $sizeBytes): self
    {
        $obj = clone $this;
        $obj->sizeBytes = $sizeBytes;

        return $obj;
    }

    /**
     * Whether the file can be downloaded.
     */
    public function withDownloadable(bool $downloadable): self
    {
        $obj = clone $this;
        $obj->downloadable = $downloadable;

        return $obj;
    }
}
