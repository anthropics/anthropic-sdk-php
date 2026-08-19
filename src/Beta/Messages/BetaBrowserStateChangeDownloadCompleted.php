<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A file download that finished during this call, reported with the
 * same `download_id` as its `download_started` — or without a prior
 * `download_started`, when the download finished during the call that
 * started it (at most one state change per `download_id` per result).
 *
 * @phpstan-type BetaBrowserStateChangeDownloadCompletedShape = array{
 *   downloadID: string,
 *   type: 'download_completed',
 *   url: string,
 *   path?: string|null,
 *   sizeBytes?: int|null,
 * }
 */
final class BetaBrowserStateChangeDownloadCompleted implements BaseModel
{
    /** @use SdkModel<BetaBrowserStateChangeDownloadCompletedShape> */
    use SdkModel;

    /** @var 'download_completed' $type */
    #[Required]
    public string $type = 'download_completed';

    /**
     * The caller-assigned identifier for this download, stable across the state changes reporting it.
     */
    #[Required('download_id')]
    public string $downloadID;

    /**
     * The final post-redirect URL the download was served from.
     */
    #[Required]
    public string $url;

    /**
     * Where the executor saved the file, on the executor's filesystem. Only included when another tool in the same environment can read the file at that path.
     */
    #[Optional(nullable: true)]
    public ?string $path;

    /**
     * The completed download's size.
     */
    #[Optional('size_bytes', nullable: true)]
    public ?int $sizeBytes;

    /**
     * `new BetaBrowserStateChangeDownloadCompleted()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserStateChangeDownloadCompleted::with(downloadID: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserStateChangeDownloadCompleted)->withDownloadID(...)->withURL(...)
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
        string $downloadID,
        string $url,
        ?string $path = null,
        ?int $sizeBytes = null,
    ): self {
        $self = new self;

        $self['downloadID'] = $downloadID;
        $self['url'] = $url;

        null !== $path && $self['path'] = $path;
        null !== $sizeBytes && $self['sizeBytes'] = $sizeBytes;

        return $self;
    }

    /**
     * The caller-assigned identifier for this download, stable across the state changes reporting it.
     */
    public function withDownloadID(string $downloadID): self
    {
        $self = clone $this;
        $self['downloadID'] = $downloadID;

        return $self;
    }

    /**
     * @param 'download_completed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The final post-redirect URL the download was served from.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Where the executor saved the file, on the executor's filesystem. Only included when another tool in the same environment can read the file at that path.
     */
    public function withPath(?string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * The completed download's size.
     */
    public function withSizeBytes(?int $sizeBytes): self
    {
        $self = clone $this;
        $self['sizeBytes'] = $sizeBytes;

        return $self;
    }
}
