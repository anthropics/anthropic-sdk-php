<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaCacheMissModelChangedShape from \Anthropic\Beta\Messages\BetaCacheMissModelChanged
 * @phpstan-import-type BetaCacheMissSystemChangedShape from \Anthropic\Beta\Messages\BetaCacheMissSystemChanged
 * @phpstan-import-type BetaCacheMissToolsChangedShape from \Anthropic\Beta\Messages\BetaCacheMissToolsChanged
 * @phpstan-import-type BetaCacheMissMessagesChangedShape from \Anthropic\Beta\Messages\BetaCacheMissMessagesChanged
 * @phpstan-import-type BetaCacheMissPreviousMessageNotFoundShape from \Anthropic\Beta\Messages\BetaCacheMissPreviousMessageNotFound
 * @phpstan-import-type BetaCacheMissUnavailableShape from \Anthropic\Beta\Messages\BetaCacheMissUnavailable
 *
 * @phpstan-type BetaCacheMissReasonVariants = BetaCacheMissModelChanged|BetaCacheMissSystemChanged|BetaCacheMissToolsChanged|BetaCacheMissMessagesChanged|BetaCacheMissPreviousMessageNotFound|BetaCacheMissUnavailable
 * @phpstan-type BetaCacheMissReasonShape = BetaCacheMissReasonVariants|BetaCacheMissModelChangedShape|BetaCacheMissSystemChangedShape|BetaCacheMissToolsChangedShape|BetaCacheMissMessagesChangedShape|BetaCacheMissPreviousMessageNotFoundShape|BetaCacheMissUnavailableShape
 */
final class BetaCacheMissReason implements ConverterSource
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
