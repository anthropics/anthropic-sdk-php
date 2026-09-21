<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\BetaErrorResponse;
use Anthropic\Beta\Messages\Batches\MessageBatchResult\Type;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Processing result for this request.
 *
 * Contains a Message output if processing was successful, an error response if processing failed, or the reason why processing was not attempted, such as cancellation or expiration.
 *
 * @phpstan-import-type MessageBatchSucceededResultShape from \Anthropic\Beta\Messages\Batches\MessageBatchSucceededResult
 * @phpstan-import-type MessageBatchErroredResultShape from \Anthropic\Beta\Messages\Batches\MessageBatchErroredResult
 * @phpstan-import-type MessageBatchCanceledResultShape from \Anthropic\Beta\Messages\Batches\MessageBatchCanceledResult
 * @phpstan-import-type MessageBatchExpiredResultShape from \Anthropic\Beta\Messages\Batches\MessageBatchExpiredResult
 * @phpstan-import-type BetaMessageShape from \Anthropic\Beta\Messages\BetaMessage
 * @phpstan-import-type BetaErrorResponseShape from \Anthropic\Beta\BetaErrorResponse
 *
 * @phpstan-type MessageBatchResultVariants = MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult
 * @phpstan-type MessageBatchResultShape = MessageBatchResultVariants|MessageBatchSucceededResultShape|MessageBatchErroredResultShape|MessageBatchCanceledResultShape|MessageBatchExpiredResultShape
 */
final class MessageBatchResult implements ConverterSource
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
            'succeeded' => MessageBatchSucceededResult::class,
            'errored' => MessageBatchErroredResult::class,
            'canceled' => MessageBatchCanceledResult::class,
            'expired' => MessageBatchExpiredResult::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaMessage|BetaMessageShape|null $message
     * @param BetaErrorResponse|BetaErrorResponseShape|null $error
     *
     * @return ($type is Type::SUCCEEDED|'succeeded' ? MessageBatchSucceededResult : ($type is Type::ERRORED|'errored' ? MessageBatchErroredResult : ($type is Type::CANCELED|'canceled' ? MessageBatchCanceledResult : ($type is Type::EXPIRED|'expired' ? MessageBatchExpiredResult : MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaMessage|array|null $message = null,
        BetaErrorResponse|array|null $error = null,
    ): MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult {
        return match ($type) {
            Type::SUCCEEDED, 'succeeded' => MessageBatchSucceededResult::with(
                message: $message ?? throw new \ArgumentCountError('$message is required'),
            ),
            Type::ERRORED, 'errored' => MessageBatchErroredResult::with(
                error: $error ?? throw new \ArgumentCountError('$error is required')
            ),
            Type::CANCELED, 'canceled' => MessageBatchCanceledResult::with(),
            Type::EXPIRED, 'expired' => MessageBatchExpiredResult::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
