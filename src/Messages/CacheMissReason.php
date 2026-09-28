<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type CacheMissModelChangedShape from \Anthropic\Messages\CacheMissModelChanged
 * @phpstan-import-type CacheMissSystemChangedShape from \Anthropic\Messages\CacheMissSystemChanged
 * @phpstan-import-type CacheMissToolsChangedShape from \Anthropic\Messages\CacheMissToolsChanged
 * @phpstan-import-type CacheMissMessagesChangedShape from \Anthropic\Messages\CacheMissMessagesChanged
 * @phpstan-import-type CacheMissPreviousMessageNotFoundShape from \Anthropic\Messages\CacheMissPreviousMessageNotFound
 * @phpstan-import-type CacheMissUnavailableShape from \Anthropic\Messages\CacheMissUnavailable
 *
 * @phpstan-type CacheMissReasonVariants = CacheMissModelChanged|CacheMissSystemChanged|CacheMissToolsChanged|CacheMissMessagesChanged|CacheMissPreviousMessageNotFound|CacheMissUnavailable
 * @phpstan-type CacheMissReasonShape = CacheMissReasonVariants|CacheMissModelChangedShape|CacheMissSystemChangedShape|CacheMissToolsChangedShape|CacheMissMessagesChangedShape|CacheMissPreviousMessageNotFoundShape|CacheMissUnavailableShape
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
            'model_changed' => CacheMissModelChanged::class,
            'system_changed' => CacheMissSystemChanged::class,
            'tools_changed' => CacheMissToolsChanged::class,
            'messages_changed' => CacheMissMessagesChanged::class,
            'previous_message_not_found' => CacheMissPreviousMessageNotFound::class,
            'unavailable' => CacheMissUnavailable::class,
        ];
    }
}
