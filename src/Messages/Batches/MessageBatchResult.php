<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Processing result for this request.
 *
 * Contains a Message output if processing was successful, an error response if processing failed, or the reason why processing was not attempted, such as cancellation or expiration.
 *
 * @phpstan-import-type MessageBatchSucceededResultShape from \Anthropic\Messages\Batches\MessageBatchSucceededResult
 * @phpstan-import-type MessageBatchErroredResultShape from \Anthropic\Messages\Batches\MessageBatchErroredResult
 * @phpstan-import-type MessageBatchCanceledResultShape from \Anthropic\Messages\Batches\MessageBatchCanceledResult
 * @phpstan-import-type MessageBatchExpiredResultShape from \Anthropic\Messages\Batches\MessageBatchExpiredResult
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
}
