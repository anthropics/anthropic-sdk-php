<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent;

use Anthropic\Beta\Agents\BetaManagedAgentsAnthropicSkill;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomSkill;
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
}
