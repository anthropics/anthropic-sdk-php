<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Beta\Messages\BetaSystemMessageParam\ClearAt;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaUserMessageParamShape from \Anthropic\Beta\Messages\BetaUserMessageParam
 * @phpstan-import-type BetaAssistantMessageParamShape from \Anthropic\Beta\Messages\BetaAssistantMessageParam
 * @phpstan-import-type BetaSystemMessageParamShape from \Anthropic\Beta\Messages\BetaSystemMessageParam
 * @phpstan-import-type BetaMessageContentParamShape from \Anthropic\Beta\Messages\BetaMessageContentParam
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaSystemMessageParam\Content
 * @phpstan-import-type BetaSystemMessageOutputConfigShape from \Anthropic\Beta\Messages\BetaSystemMessageOutputConfig
 *
 * @phpstan-type BetaMessageParamVariants = BetaUserMessageParam|BetaAssistantMessageParam|BetaSystemMessageParam
 * @phpstan-type BetaMessageParamShape = BetaMessageParamVariants|BetaUserMessageParamShape|BetaAssistantMessageParamShape|BetaSystemMessageParamShape
 */
final class BetaMessageParam implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'role';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'user' => BetaUserMessageParam::class,
            'assistant' => BetaAssistantMessageParam::class,
            'system' => BetaSystemMessageParam::class,
        ];
    }

    /**
     * Constructs the variant whose `role` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($role is Role::USER|'user'|Role::ASSISTANT|'assistant' ? BetaMessageContentParamShape|null : ContentShape|null) $content
     * @param ClearAt|value-of<ClearAt>|null $clearAt
     * @param BetaSystemMessageOutputConfig|BetaSystemMessageOutputConfigShape|null $outputConfig
     *
     * @return ($role is Role::USER|'user' ? BetaUserMessageParam : ($role is Role::ASSISTANT|'assistant' ? BetaAssistantMessageParam : ($role is Role::SYSTEM|'system' ? BetaSystemMessageParam : BetaUserMessageParam|BetaAssistantMessageParam|BetaSystemMessageParam)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Role|string $role,
        string|array|null $content = null,
        ClearAt|string|null $clearAt = null,
        BetaSystemMessageOutputConfig|array|null $outputConfig = null,
    ): BetaUserMessageParam|BetaAssistantMessageParam|BetaSystemMessageParam {
        return match ($role) {
            Role::USER, 'user' => BetaUserMessageParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            Role::ASSISTANT, 'assistant' => BetaAssistantMessageParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            Role::SYSTEM, 'system' => BetaSystemMessageParam::with(
                clearAt: $clearAt,
                // @phpstan-ignore argument.type
                content: $content,
                outputConfig: $outputConfig,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($role, true)))
        };
    }
}
