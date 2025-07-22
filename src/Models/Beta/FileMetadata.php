<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        \DateTimeInterface $createdAt,
        string $filename,
        string $mimeType,
        int $sizeBytes,
        ?bool $downloadable = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->filename = $filename;
        $this->mimeType = $mimeType;
        $this->sizeBytes = $sizeBytes;

        null !== $downloadable && $this->downloadable = $downloadable;
    }
}
