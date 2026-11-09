<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyMode\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How Claude takes part in a Slack channel. A channel alone stores one. More types can be added.
 *
 * @phpstan-import-type ClaudeTagReplyModeAutomaticShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyModeAutomatic
 * @phpstan-import-type ClaudeTagReplyModeMentionOnlyShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyModeMentionOnly
 * @phpstan-import-type ClaudeTagReplyModeAlwaysAwakeShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyModeAlwaysAwake
 * @phpstan-import-type ClaudeTagReplyModeThreadShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyModeThread
 *
 * @phpstan-type ClaudeTagReplyModeVariants = ClaudeTagReplyModeAutomatic|ClaudeTagReplyModeMentionOnly|ClaudeTagReplyModeAlwaysAwake|ClaudeTagReplyModeThread
 * @phpstan-type ClaudeTagReplyModeShape = ClaudeTagReplyModeVariants|ClaudeTagReplyModeAutomaticShape|ClaudeTagReplyModeMentionOnlyShape|ClaudeTagReplyModeAlwaysAwakeShape|ClaudeTagReplyModeThreadShape
 */
final class ClaudeTagReplyMode implements ConverterSource
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
            'automatic' => ClaudeTagReplyModeAutomatic::class,
            'mention_only' => ClaudeTagReplyModeMentionOnly::class,
            'always_awake' => ClaudeTagReplyModeAlwaysAwake::class,
            'thread' => ClaudeTagReplyModeThread::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AUTOMATIC|'automatic' ? ClaudeTagReplyModeAutomatic : ($type is Type::MENTION_ONLY|'mention_only' ? ClaudeTagReplyModeMentionOnly : ($type is Type::ALWAYS_AWAKE|'always_awake' ? ClaudeTagReplyModeAlwaysAwake : ($type is Type::THREAD|'thread' ? ClaudeTagReplyModeThread : ClaudeTagReplyModeAutomatic|ClaudeTagReplyModeMentionOnly|ClaudeTagReplyModeAlwaysAwake|ClaudeTagReplyModeThread))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): ClaudeTagReplyModeAutomatic|ClaudeTagReplyModeMentionOnly|ClaudeTagReplyModeAlwaysAwake|ClaudeTagReplyModeThread {
        return match ($type) {
            Type::AUTOMATIC, 'automatic' => ClaudeTagReplyModeAutomatic::with(),
            Type::MENTION_ONLY, 'mention_only' => ClaudeTagReplyModeMentionOnly::with(
            ),
            Type::ALWAYS_AWAKE, 'always_awake' => ClaudeTagReplyModeAlwaysAwake::with(
            ),
            Type::THREAD, 'thread' => ClaudeTagReplyModeThread::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
