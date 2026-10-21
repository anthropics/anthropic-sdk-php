<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\MessageParam\Role;

/**
 * @phpstan-import-type UserMessageParamShape from \Anthropic\Messages\UserMessageParam
 * @phpstan-import-type AssistantMessageParamShape from \Anthropic\Messages\AssistantMessageParam
 * @phpstan-import-type SystemMessageParamShape from \Anthropic\Messages\SystemMessageParam
 * @phpstan-import-type MessageContentParamShape from \Anthropic\Messages\MessageContentParam
 * @phpstan-import-type ContentShape from \Anthropic\Messages\SystemMessageParam\Content
 *
 * @phpstan-type MessageParamVariants = UserMessageParam|AssistantMessageParam|SystemMessageParam
 * @phpstan-type MessageParamShape = MessageParamVariants|UserMessageParamShape|AssistantMessageParamShape|SystemMessageParamShape
 */
final class MessageParam implements ConverterSource
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
            'user' => UserMessageParam::class,
            'assistant' => AssistantMessageParam::class,
            'system' => SystemMessageParam::class,
        ];
    }

    /**
     * Constructs the variant whose `role` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($role is Role::USER|'user'|Role::ASSISTANT|'assistant' ? MessageContentParamShape : ContentShape) $content
     *
     * @return ($role is Role::USER|'user' ? UserMessageParam : ($role is Role::ASSISTANT|'assistant' ? AssistantMessageParam : ($role is Role::SYSTEM|'system' ? SystemMessageParam : UserMessageParam|AssistantMessageParam|SystemMessageParam)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Role|string $role,
        string|array $content
    ): UserMessageParam|AssistantMessageParam|SystemMessageParam {
        return match ($role) {
            Role::USER, 'user' => UserMessageParam::with(
                // @phpstan-ignore argument.type
                content: $content,
            ),
            Role::ASSISTANT, 'assistant' => AssistantMessageParam::with(
                // @phpstan-ignore argument.type
                content: $content,
            ),
            Role::SYSTEM, 'system' => SystemMessageParam::with(
                // @phpstan-ignore argument.type
                content: $content,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($role, true)))
        };
    }
}
