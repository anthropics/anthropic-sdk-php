<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A file download that started during this call.
 *
 * @phpstan-type BrowserStateChangeDownloadStartedShape = array{
 *   downloadID: string, type: 'download_started', url: string
 * }
 */
final class BrowserStateChangeDownloadStarted implements BaseModel
{
    /** @use SdkModel<BrowserStateChangeDownloadStartedShape> */
    use SdkModel;

    /** @var 'download_started' $type */
    #[Required]
    public string $type = 'download_started';

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
     * `new BrowserStateChangeDownloadStarted()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserStateChangeDownloadStarted::with(downloadID: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserStateChangeDownloadStarted)->withDownloadID(...)->withURL(...)
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
    public static function with(string $downloadID, string $url): self
    {
        $self = new self;

        $self['downloadID'] = $downloadID;
        $self['url'] = $url;

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
     * @param 'download_started' $type
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
}
