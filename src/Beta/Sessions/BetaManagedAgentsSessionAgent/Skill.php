<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent;

use Anthropic\Beta\Agents\BetaManagedAgentsAnthropicSkill;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomSkill;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Skill\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Resolved skill as returned in API responses.
 *
 * @phpstan-import-type BetaManagedAgentsAnthropicSkillShape from \Anthropic\Beta\Agents\BetaManagedAgentsAnthropicSkill
 * @phpstan-import-type BetaManagedAgentsCustomSkillShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomSkill
 *
 * @phpstan-type SkillVariants = BetaManagedAgentsAnthropicSkill|BetaManagedAgentsCustomSkill
 * @phpstan-type SkillShape = SkillVariants|BetaManagedAgentsAnthropicSkillShape|BetaManagedAgentsCustomSkillShape
 */
final class Skill implements ConverterSource
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
            'anthropic' => BetaManagedAgentsAnthropicSkill::class,
            'custom' => BetaManagedAgentsCustomSkill::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ANTHROPIC|'anthropic' ? BetaManagedAgentsAnthropicSkill : ($type is Type::CUSTOM|'custom' ? BetaManagedAgentsCustomSkill : BetaManagedAgentsAnthropicSkill|BetaManagedAgentsCustomSkill))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $skillID,
        string $version,
    ): BetaManagedAgentsAnthropicSkill|BetaManagedAgentsCustomSkill {
        return match ($type) {
            Type::ANTHROPIC, 'anthropic' => BetaManagedAgentsAnthropicSkill::with(
                type: 'anthropic',
                skillID: $skillID,
                version: $version
            ),
            Type::CUSTOM, 'custom' => BetaManagedAgentsCustomSkill::with(
                type: 'custom',
                skillID: $skillID,
                version: $version
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
