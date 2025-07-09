<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class FileMetadata implements BaseModel
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
    public ?bool $downloadable;

    /**
     * @param string             $id
     * @param \DateTimeInterface $createdAt
     * @param string             $filename
     * @param string             $mimeType
     * @param int                $sizeBytes
     * @param string             $type
     * @param null|bool          $downloadable
     */
    final public function __construct(
        $id,
        $createdAt,
        $filename,
        $mimeType,
        $sizeBytes,
        $type,
        $downloadable = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

FileMetadata::_loadMetadata();
