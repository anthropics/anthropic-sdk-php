<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

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
}
