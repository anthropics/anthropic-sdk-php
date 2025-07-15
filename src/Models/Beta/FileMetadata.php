<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class FileMetadata implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    #[Api]
    public string $filename;

    #[Api('mime_type')]
    public string $mimeType;

    #[Api('size_bytes')]
    public int $sizeBytes;

    #[Api]
    public string $type;

    #[Api(optional: true)]
    public ?bool $downloadable = false;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        \DateTimeInterface $createdAt,
        string $filename,
        string $mimeType,
        int $sizeBytes,
        string $type,
        ?bool $downloadable = null,
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->filename = $filename;
        $this->mimeType = $mimeType;
        $this->sizeBytes = $sizeBytes;
        $this->type = $type;
        $this->downloadable = $downloadable;
    }
}

FileMetadata::_loadMetadata();
