<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaDiagnostics;

use Anthropic\Beta\Messages\BetaCacheMissMessagesChanged;
use Anthropic\Beta\Messages\BetaCacheMissModelChanged;
use Anthropic\Beta\Messages\BetaCacheMissPreviousMessageNotFound;
use Anthropic\Beta\Messages\BetaCacheMissSystemChanged;
use Anthropic\Beta\Messages\BetaCacheMissToolsChanged;
use Anthropic\Beta\Messages\BetaCacheMissUnavailable;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Explains why the prompt cache could not fully reuse the prefix from the request identified by `diagnostics.previous_message_id`. `null` means diagnosis is still pending — the response was serialized before the background comparison completed.
 *
 * @phpstan-import-type BetaCacheMissModelChangedShape from \Anthropic\Beta\Messages\BetaCacheMissModelChanged
 * @phpstan-import-type BetaCacheMissSystemChangedShape from \Anthropic\Beta\Messages\BetaCacheMissSystemChanged
 * @phpstan-import-type BetaCacheMissToolsChangedShape from \Anthropic\Beta\Messages\BetaCacheMissToolsChanged
 * @phpstan-import-type BetaCacheMissMessagesChangedShape from \Anthropic\Beta\Messages\BetaCacheMissMessagesChanged
 * @phpstan-import-type BetaCacheMissPreviousMessageNotFoundShape from \Anthropic\Beta\Messages\BetaCacheMissPreviousMessageNotFound
 * @phpstan-import-type BetaCacheMissUnavailableShape from \Anthropic\Beta\Messages\BetaCacheMissUnavailable
 *
 * @phpstan-type CacheMissReasonVariants = BetaCacheMissModelChanged|BetaCacheMissSystemChanged|BetaCacheMissToolsChanged|BetaCacheMissMessagesChanged|BetaCacheMissPreviousMessageNotFound|BetaCacheMissUnavailable
 * @phpstan-type CacheMissReasonShape = CacheMissReasonVariants|BetaCacheMissModelChangedShape|BetaCacheMissSystemChangedShape|BetaCacheMissToolsChangedShape|BetaCacheMissMessagesChangedShape|BetaCacheMissPreviousMessageNotFoundShape|BetaCacheMissUnavailableShape
 */
final class CacheMissReason implements ConverterSource
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
            'model_changed' => BetaCacheMissModelChanged::class,
            'system_changed' => BetaCacheMissSystemChanged::class,
            'tools_changed' => BetaCacheMissToolsChanged::class,
            'messages_changed' => BetaCacheMissMessagesChanged::class,
            'previous_message_not_found' => BetaCacheMissPreviousMessageNotFound::class,
            'unavailable' => BetaCacheMissUnavailable::class,
        ];
    }
}
