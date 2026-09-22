<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBrowserStateChange\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBrowserStateChangeTabOpenedShape from \Anthropic\Beta\Messages\BetaBrowserStateChangeTabOpened
 * @phpstan-import-type BetaBrowserStateChangeDownloadStartedShape from \Anthropic\Beta\Messages\BetaBrowserStateChangeDownloadStarted
 * @phpstan-import-type BetaBrowserStateChangeDownloadCompletedShape from \Anthropic\Beta\Messages\BetaBrowserStateChangeDownloadCompleted
 * @phpstan-import-type BetaBrowserStateChangeDownloadFailedShape from \Anthropic\Beta\Messages\BetaBrowserStateChangeDownloadFailed
 *
 * @phpstan-type BetaBrowserStateChangeVariants = BetaBrowserStateChangeTabOpened|BetaBrowserStateChangeDownloadStarted|BetaBrowserStateChangeDownloadCompleted|BetaBrowserStateChangeDownloadFailed
 * @phpstan-type BetaBrowserStateChangeShape = BetaBrowserStateChangeVariants|BetaBrowserStateChangeTabOpenedShape|BetaBrowserStateChangeDownloadStartedShape|BetaBrowserStateChangeDownloadCompletedShape|BetaBrowserStateChangeDownloadFailedShape
 */
final class BetaBrowserStateChange implements ConverterSource
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
            'tab_opened' => BetaBrowserStateChangeTabOpened::class,
            'download_started' => BetaBrowserStateChangeDownloadStarted::class,
            'download_completed' => BetaBrowserStateChangeDownloadCompleted::class,
            'download_failed' => BetaBrowserStateChangeDownloadFailed::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::TAB_OPENED|'tab_opened' ? BetaBrowserStateChangeTabOpened : ($type is Type::DOWNLOAD_STARTED|'download_started' ? BetaBrowserStateChangeDownloadStarted : ($type is Type::DOWNLOAD_COMPLETED|'download_completed' ? BetaBrowserStateChangeDownloadCompleted : ($type is Type::DOWNLOAD_FAILED|'download_failed' ? BetaBrowserStateChangeDownloadFailed : BetaBrowserStateChangeTabOpened|BetaBrowserStateChangeDownloadStarted|BetaBrowserStateChangeDownloadCompleted|BetaBrowserStateChangeDownloadFailed))))
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
    ): BetaBrowserStateChangeTabOpened|BetaBrowserStateChangeDownloadStarted|BetaBrowserStateChangeDownloadCompleted|BetaBrowserStateChangeDownloadFailed {
        return match ($type) {
            Type::TAB_OPENED, 'tab_opened' => BetaBrowserStateChangeTabOpened::with(
                tabID: $tabID ?? throw new \ArgumentCountError('$tabID is required')
            ),
            Type::DOWNLOAD_STARTED, 'download_started' => BetaBrowserStateChangeDownloadStarted::with(
                downloadID: $downloadID ?? throw new \ArgumentCountError('$downloadID is required'),
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::DOWNLOAD_COMPLETED, 'download_completed' => BetaBrowserStateChangeDownloadCompleted::with(
                downloadID: $downloadID ?? throw new \ArgumentCountError('$downloadID is required'),
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                path: $path,
                sizeBytes: $sizeBytes,
            ),
            Type::DOWNLOAD_FAILED, 'download_failed' => BetaBrowserStateChangeDownloadFailed::with(
                downloadID: $downloadID ?? throw new \ArgumentCountError('$downloadID is required'),
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                error: $error,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
