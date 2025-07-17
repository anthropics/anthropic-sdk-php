<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class MessageBatchResult implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
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
