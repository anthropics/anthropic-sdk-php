<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\BrowserStateChange\Type;

/**
 * @phpstan-import-type BrowserStateChangeTabOpenedShape from \Anthropic\Messages\BrowserStateChangeTabOpened
 * @phpstan-import-type BrowserStateChangeDownloadStartedShape from \Anthropic\Messages\BrowserStateChangeDownloadStarted
 * @phpstan-import-type BrowserStateChangeDownloadCompletedShape from \Anthropic\Messages\BrowserStateChangeDownloadCompleted
 * @phpstan-import-type BrowserStateChangeDownloadFailedShape from \Anthropic\Messages\BrowserStateChangeDownloadFailed
 *
 * @phpstan-type BrowserStateChangeVariants = BrowserStateChangeTabOpened|BrowserStateChangeDownloadStarted|BrowserStateChangeDownloadCompleted|BrowserStateChangeDownloadFailed
 * @phpstan-type BrowserStateChangeShape = BrowserStateChangeVariants|BrowserStateChangeTabOpenedShape|BrowserStateChangeDownloadStartedShape|BrowserStateChangeDownloadCompletedShape|BrowserStateChangeDownloadFailedShape
 */
final class BrowserStateChange implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'tab_opened' => BrowserStateChangeTabOpened::class,
            'download_started' => BrowserStateChangeDownloadStarted::class,
            'download_completed' => BrowserStateChangeDownloadCompleted::class,
            'download_failed' => BrowserStateChangeDownloadFailed::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::TAB_OPENED|'tab_opened' ? BrowserStateChangeTabOpened : ($type is Type::DOWNLOAD_STARTED|'download_started' ? BrowserStateChangeDownloadStarted : ($type is Type::DOWNLOAD_COMPLETED|'download_completed' ? BrowserStateChangeDownloadCompleted : ($type is Type::DOWNLOAD_FAILED|'download_failed' ? BrowserStateChangeDownloadFailed : BrowserStateChangeTabOpened|BrowserStateChangeDownloadStarted|BrowserStateChangeDownloadCompleted|BrowserStateChangeDownloadFailed))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $tabID = null,
        ?string $downloadID = null,
        ?string $url = null,
        ?string $path = null,
        ?int $sizeBytes = null,
        ?string $error = null,
    ): BrowserStateChangeTabOpened|BrowserStateChangeDownloadStarted|BrowserStateChangeDownloadCompleted|BrowserStateChangeDownloadFailed {
        return match ($type) {
            Type::TAB_OPENED, 'tab_opened' => BrowserStateChangeTabOpened::with(
                tabID: $tabID ?? throw new \ArgumentCountError('$tabID is required')
            ),
            Type::DOWNLOAD_STARTED, 'download_started' => BrowserStateChangeDownloadStarted::with(
                downloadID: $downloadID ?? throw new \ArgumentCountError('$downloadID is required'),
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::DOWNLOAD_COMPLETED, 'download_completed' => BrowserStateChangeDownloadCompleted::with(
                downloadID: $downloadID ?? throw new \ArgumentCountError('$downloadID is required'),
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                path: $path,
                sizeBytes: $sizeBytes,
            ),
            Type::DOWNLOAD_FAILED, 'download_failed' => BrowserStateChangeDownloadFailed::with(
                downloadID: $downloadID ?? throw new \ArgumentCountError('$downloadID is required'),
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                error: $error,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
