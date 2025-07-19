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
    public string $type = 'file';

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
