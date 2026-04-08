<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

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
}
