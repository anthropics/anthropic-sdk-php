<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A tab this call's execution opened that remains open at its end —
 * the creation delta of the `tabs` inventory, not an event log.
 *
 * Carries only the `tab_id`; the tab's `title` and `url` live on its
 * `tabs` entry, which must include the same `tab_id`. A tab opened
 * during a failed call gets no deferred `tab_opened`; it simply appears
 * in the next result's `tabs` inventory.
 *
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
}
