<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type file_metadata_alias = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   filename: string,
 *   mimeType: string,
 *   sizeBytes: int,
 *   type: string,
 *   downloadable?: bool,
 * }
 */
final class FileMetadata implements BaseModel
{
    use Model;

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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
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
    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * RFC 3339 datetime string representing when the file was created.
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Original filename of the uploaded file.
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * MIME type of the file.
     */
    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Size of the file in bytes.
     */
    public function setSizeBytes(int $sizeBytes): self
    {
        $this->sizeBytes = $sizeBytes;

        return $this;
    }

    /**
     * Whether the file can be downloaded.
     */
    public function setDownloadable(bool $downloadable): self
    {
        $this->downloadable = $downloadable;

        return $this;
    }
}
