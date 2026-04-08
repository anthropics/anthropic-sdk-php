<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfig;

use Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAllowPolicy;
use Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAskPolicy;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Permission policy for tool execution.
 *
 * @phpstan-import-type BetaManagedAgentsAlwaysAllowPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAllowPolicy
 * @phpstan-import-type BetaManagedAgentsAlwaysAskPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsAlwaysAskPolicy
 *
 * @phpstan-type PermissionPolicyVariants = BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy
 * @phpstan-type PermissionPolicyShape = PermissionPolicyVariants|BetaManagedAgentsAlwaysAllowPolicyShape|BetaManagedAgentsAlwaysAskPolicyShape
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
        ];
    }
}
