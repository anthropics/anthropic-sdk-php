<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig;

use Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAllowPolicy;
use Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAskPolicy;
use Anthropic\Beta\Agents\BetaManagedAgentsAutoPolicy;
use Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig\PermissionPolicy\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Permission policy for tool execution.
 *
 * @phpstan-import-type BetaManagedAgentsAlwaysAllowPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAllowPolicy
 * @phpstan-import-type BetaManagedAgentsAlwaysAskPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAskPolicy
 * @phpstan-import-type BetaManagedAgentsAutoPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsAutoPolicy
 *
 * @phpstan-type PermissionPolicyVariants = BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy|BetaManagedAgentsAutoPolicy
 * @phpstan-type PermissionPolicyShape = PermissionPolicyVariants|BetaManagedAgentsAlwaysAllowPolicyShape|BetaManagedAgentsAlwaysAskPolicyShape|BetaManagedAgentsAutoPolicyShape
 */
final class PermissionPolicy implements ConverterSource
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
            'always_allow' => BetaManagedAgentsAlwaysAllowPolicy::class,
            'always_ask' => BetaManagedAgentsAlwaysAskPolicy::class,
            'auto' => BetaManagedAgentsAutoPolicy::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ALWAYS_ALLOW|'always_allow' ? BetaManagedAgentsAlwaysAllowPolicy : ($type is Type::ALWAYS_ASK|'always_ask' ? BetaManagedAgentsAlwaysAskPolicy : ($type is Type::AUTO|'auto' ? BetaManagedAgentsAutoPolicy : BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy|BetaManagedAgentsAutoPolicy)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy|BetaManagedAgentsAutoPolicy {
        return match ($type) {
            Type::ALWAYS_ALLOW, 'always_allow' => BetaManagedAgentsAlwaysAllowPolicy::with(
                type: 'always_allow'
            ),
            Type::ALWAYS_ASK, 'always_ask' => BetaManagedAgentsAlwaysAskPolicy::with(
                type: 'always_ask'
            ),
            Type::AUTO, 'auto' => BetaManagedAgentsAutoPolicy::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
