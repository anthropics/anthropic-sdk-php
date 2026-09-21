<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaDiagnostics;

use Anthropic\Beta\Messages\BetaCacheMissMessagesChanged;
use Anthropic\Beta\Messages\BetaCacheMissModelChanged;
use Anthropic\Beta\Messages\BetaCacheMissPreviousMessageNotFound;
use Anthropic\Beta\Messages\BetaCacheMissSystemChanged;
use Anthropic\Beta\Messages\BetaCacheMissToolsChanged;
use Anthropic\Beta\Messages\BetaCacheMissUnavailable;
use Anthropic\Beta\Messages\BetaDiagnostics\CacheMissReason\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::MODEL_CHANGED|'model_changed' ? BetaCacheMissModelChanged : ($type is Type::SYSTEM_CHANGED|'system_changed' ? BetaCacheMissSystemChanged : ($type is Type::TOOLS_CHANGED|'tools_changed' ? BetaCacheMissToolsChanged : ($type is Type::MESSAGES_CHANGED|'messages_changed' ? BetaCacheMissMessagesChanged : ($type is Type::PREVIOUS_MESSAGE_NOT_FOUND|'previous_message_not_found' ? BetaCacheMissPreviousMessageNotFound : ($type is Type::UNAVAILABLE|'unavailable' ? BetaCacheMissUnavailable : BetaCacheMissModelChanged|BetaCacheMissSystemChanged|BetaCacheMissToolsChanged|BetaCacheMissMessagesChanged|BetaCacheMissPreviousMessageNotFound|BetaCacheMissUnavailable))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?int $cacheMissedInputTokens = null
    ): BetaCacheMissModelChanged|BetaCacheMissSystemChanged|BetaCacheMissToolsChanged|BetaCacheMissMessagesChanged|BetaCacheMissPreviousMessageNotFound|BetaCacheMissUnavailable {
        return match ($type) {
            Type::MODEL_CHANGED, 'model_changed' => BetaCacheMissModelChanged::with(
                cacheMissedInputTokens: $cacheMissedInputTokens ?? throw new \ArgumentCountError('$cacheMissedInputTokens is required'),
            ),
            Type::SYSTEM_CHANGED, 'system_changed' => BetaCacheMissSystemChanged::with(
                cacheMissedInputTokens: $cacheMissedInputTokens ?? throw new \ArgumentCountError('$cacheMissedInputTokens is required'),
            ),
            Type::TOOLS_CHANGED, 'tools_changed' => BetaCacheMissToolsChanged::with(
                cacheMissedInputTokens: $cacheMissedInputTokens ?? throw new \ArgumentCountError('$cacheMissedInputTokens is required'),
            ),
            Type::MESSAGES_CHANGED, 'messages_changed' => BetaCacheMissMessagesChanged::with(
                cacheMissedInputTokens: $cacheMissedInputTokens ?? throw new \ArgumentCountError('$cacheMissedInputTokens is required'),
            ),
            Type::PREVIOUS_MESSAGE_NOT_FOUND, 'previous_message_not_found' => BetaCacheMissPreviousMessageNotFound::with(
            ),
            Type::UNAVAILABLE, 'unavailable' => BetaCacheMissUnavailable::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
