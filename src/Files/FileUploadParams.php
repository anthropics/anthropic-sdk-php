<?php

declare(strict_types=1);

namespace Anthropic\Files;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\FileParam;

/**
 * Upload File.
 *
 * @see Anthropic\Services\FilesService::upload()
 *
 * @phpstan-type FileUploadParamsShape = array{
 *   file: string|FileParam, expiresInSeconds?: int|null
 * }
 */
final class FileUploadParams implements BaseModel
{
    /** @use SdkModel<FileUploadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The file to upload.
     */
    #[Required]
    public string $file;

    /**
     * Seconds from upload until the file expires and its bytes become permanently unavailable. Must be between 3600 (one hour) and 7776000 (ninety days).
     */
    #[Optional('expires_in_seconds')]
    public ?int $expiresInSeconds;

    /**
     * `new FileUploadParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FileUploadParams::with(file: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FileUploadParams)->withFile(...)
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
        string|FileParam $file,
        ?int $expiresInSeconds = null
    ): self {
        $self = new self;

        $self['file'] = $file;

        null !== $expiresInSeconds && $self['expiresInSeconds'] = $expiresInSeconds;

        return $self;
    }

    /**
     * The file to upload.
     */
    public function withFile(string|FileParam $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }

    /**
     * Seconds from upload until the file expires and its bytes become permanently unavailable. Must be between 3600 (one hour) and 7776000 (ninety days).
     */
    public function withExpiresInSeconds(int $expiresInSeconds): self
    {
        $self = clone $this;
        $self['expiresInSeconds'] = $expiresInSeconds;

        return $self;
    }
}
