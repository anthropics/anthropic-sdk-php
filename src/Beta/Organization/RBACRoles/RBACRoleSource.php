<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type RBACRoleSourceBuiltInShape from \Anthropic\Beta\Organization\RBACRoles\RBACRoleSourceBuiltIn
 * @phpstan-import-type RBACRoleSourceCustomShape from \Anthropic\Beta\Organization\RBACRoles\RBACRoleSourceCustom
 *
 * @phpstan-type RBACRoleSourceVariants = RBACRoleSourceBuiltIn|RBACRoleSourceCustom
 * @phpstan-type RBACRoleSourceShape = RBACRoleSourceVariants|RBACRoleSourceBuiltInShape|RBACRoleSourceCustomShape
 */
final class RBACRoleSource implements ConverterSource
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
            'built_in' => RBACRoleSourceBuiltIn::class,
            'custom' => RBACRoleSourceCustom::class,
        ];
    }
}
