<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A limit Anthropic has placed on the entity this profile represents and not yet resolved, discriminated by `type`: `restriction` or `ban`. More types may be added; read a `type` you do not recognize as `restriction`.
 *
 * @phpstan-import-type UserProfileEnforcementActionRestrictionShape from \Anthropic\UserProfiles\UserProfileEnforcementActionRestriction
 * @phpstan-import-type UserProfileEnforcementActionBanShape from \Anthropic\UserProfiles\UserProfileEnforcementActionBan
 *
 * @phpstan-type UserProfileEnforcementActionVariants = UserProfileEnforcementActionRestriction|UserProfileEnforcementActionBan
 * @phpstan-type UserProfileEnforcementActionShape = UserProfileEnforcementActionVariants|UserProfileEnforcementActionRestrictionShape|UserProfileEnforcementActionBanShape
 */
final class UserProfileEnforcementAction implements ConverterSource
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
            'restriction' => UserProfileEnforcementActionRestriction::class,
            'ban' => UserProfileEnforcementActionBan::class,
        ];
    }
}
