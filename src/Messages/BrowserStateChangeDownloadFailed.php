<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A file download that failed — or was cancelled — during this call.
 *
 * @phpstan-type BrowserStateChangeDownloadFailedShape = array{
 *   downloadID: string, type: 'download_failed', url: string, error?: string|null
 * }
 */
final class BrowserStateChangeDownloadFailed implements BaseModel
{
    /** @use SdkModel<BrowserStateChangeDownloadFailedShape> */
    use SdkModel;

    /** @var 'download_failed' $type */
    #[Required]
    public string $type = 'download_failed';

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
     * The failure or cancellation detail, when known.
     */
    #[Optional(nullable: true)]
    public ?string $error;

    /**
     * `new BrowserStateChangeDownloadFailed()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserStateChangeDownloadFailed::with(downloadID: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserStateChangeDownloadFailed)->withDownloadID(...)->withURL(...)
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
        ?string $error = null
    ): self {
        $self = new self;

        $self['downloadID'] = $downloadID;
        $self['url'] = $url;

        null !== $error && $self['error'] = $error;

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
     * @param 'download_failed' $type
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
     * The failure or cancellation detail, when known.
     */
    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }
}
