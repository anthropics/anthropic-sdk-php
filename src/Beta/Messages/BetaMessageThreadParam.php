<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMessageThreadParam\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Server-held conversation state (a Thread). `{"type": "create"}` asks the server to hold this conversation's state under the response's `id`; `{"type": "continue", "previous_message_id": ...}` resumes from a previous response so only the new turn's messages are sent. The response shape is unchanged.
 *
 * @phpstan-import-type BetaThreadCreateParamsShape from \Anthropic\Beta\Messages\BetaThreadCreateParams
 * @phpstan-import-type BetaThreadContinueParamsShape from \Anthropic\Beta\Messages\BetaThreadContinueParams
 *
 * @phpstan-type BetaMessageThreadParamVariants = BetaThreadCreateParams|BetaThreadContinueParams
 * @phpstan-type BetaMessageThreadParamShape = BetaMessageThreadParamVariants|BetaThreadCreateParamsShape|BetaThreadContinueParamsShape
 */
final class BetaMessageThreadParam implements ConverterSource
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
            'create' => BetaThreadCreateParams::class,
            'continue' => BetaThreadContinueParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CREATE|'create' ? BetaThreadCreateParams : ($type is Type::CONTINUE|'continue' ? BetaThreadContinueParams : BetaThreadCreateParams|BetaThreadContinueParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $previousMessageID = null
    ): BetaThreadCreateParams|BetaThreadContinueParams {
        return match ($type) {
            Type::CREATE, 'create' => BetaThreadCreateParams::with(),
            Type::CONTINUE, 'continue' => BetaThreadContinueParams::with(
                previousMessageID: $previousMessageID ?? throw new \ArgumentCountError('$previousMessageID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
