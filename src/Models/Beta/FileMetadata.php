<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string             $id           `required`
     * @param \DateTimeInterface $createdAt    `required`
     * @param string             $filename     `required`
     * @param string             $mimeType     `required`
     * @param int                $sizeBytes    `required`
     * @param string             $type         `required`
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
