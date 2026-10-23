<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * What Claude does in a channel while a Slack guest is in it, for everyone in the channel. It changes nothing in a channel without Slack guests. More types can be added.
 *
 * @phpstan-import-type ClaudeTagGuestPolicyAllowShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicyAllow
 * @phpstan-import-type ClaudeTagGuestPolicyRestrictShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicyRestrict
 * @phpstan-import-type ClaudeTagGuestPolicyChannelOnlyShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicyChannelOnly
 *
 * @phpstan-type ClaudeTagGuestPolicyVariants = ClaudeTagGuestPolicyAllow|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly
 * @phpstan-type ClaudeTagGuestPolicyShape = ClaudeTagGuestPolicyVariants|ClaudeTagGuestPolicyAllowShape|ClaudeTagGuestPolicyRestrictShape|ClaudeTagGuestPolicyChannelOnlyShape
 */
final class ClaudeTagGuestPolicy implements ConverterSource
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
            'allow' => ClaudeTagGuestPolicyAllow::class,
            'restrict' => ClaudeTagGuestPolicyRestrict::class,
            'channel_only' => ClaudeTagGuestPolicyChannelOnly::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ALLOW|'allow' ? ClaudeTagGuestPolicyAllow : ($type is Type::RESTRICT|'restrict' ? ClaudeTagGuestPolicyRestrict : ($type is Type::CHANNEL_ONLY|'channel_only' ? ClaudeTagGuestPolicyChannelOnly : ClaudeTagGuestPolicyAllow|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): ClaudeTagGuestPolicyAllow|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly {
        return match ($type) {
            Type::ALLOW, 'allow' => ClaudeTagGuestPolicyAllow::with(),
            Type::RESTRICT, 'restrict' => ClaudeTagGuestPolicyRestrict::with(),
            Type::CHANNEL_ONLY, 'channel_only' => ClaudeTagGuestPolicyChannelOnly::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
