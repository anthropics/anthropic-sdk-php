<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsSkillParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Skill to load in the session container.
 *
 * @phpstan-import-type BetaManagedAgentsAnthropicSkillParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAnthropicSkillParams
 * @phpstan-import-type BetaManagedAgentsCustomSkillParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomSkillParams
 *
 * @phpstan-type BetaManagedAgentsSkillParamsVariants = BetaManagedAgentsAnthropicSkillParams|BetaManagedAgentsCustomSkillParams
 * @phpstan-type BetaManagedAgentsSkillParamsShape = BetaManagedAgentsSkillParamsVariants|BetaManagedAgentsAnthropicSkillParamsShape|BetaManagedAgentsCustomSkillParamsShape
 */
final class BetaManagedAgentsSkillParams implements ConverterSource
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
            'anthropic' => BetaManagedAgentsAnthropicSkillParams::class,
            'custom' => BetaManagedAgentsCustomSkillParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ANTHROPIC|'anthropic' ? BetaManagedAgentsAnthropicSkillParams : ($type is Type::CUSTOM|'custom' ? BetaManagedAgentsCustomSkillParams : BetaManagedAgentsAnthropicSkillParams|BetaManagedAgentsCustomSkillParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $skillID,
        ?string $version = null
    ): BetaManagedAgentsAnthropicSkillParams|BetaManagedAgentsCustomSkillParams {
        return match ($type) {
            Type::ANTHROPIC, 'anthropic' => BetaManagedAgentsAnthropicSkillParams::with(
                type: 'anthropic',
                skillID: $skillID,
                version: $version
            ),
            Type::CUSTOM, 'custom' => BetaManagedAgentsCustomSkillParams::with(
                type: 'custom',
                skillID: $skillID,
                version: $version
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
