<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaClaudeCodeRBACGroupStatusActiveShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupStatusActive
 * @phpstan-import-type BetaClaudeCodeRBACGroupStatusDeletedShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupStatusDeleted
 * @phpstan-import-type BetaClaudeCodeRBACGroupStatusUnknownShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupStatusUnknown
 *
 * @phpstan-type BetaClaudeCodeRBACGroupStatusVariants = BetaClaudeCodeRBACGroupStatusActive|BetaClaudeCodeRBACGroupStatusDeleted|BetaClaudeCodeRBACGroupStatusUnknown
 * @phpstan-type BetaClaudeCodeRBACGroupStatusShape = BetaClaudeCodeRBACGroupStatusVariants|BetaClaudeCodeRBACGroupStatusActiveShape|BetaClaudeCodeRBACGroupStatusDeletedShape|BetaClaudeCodeRBACGroupStatusUnknownShape
 */
final class BetaClaudeCodeRBACGroupStatus implements ConverterSource
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
            'active' => BetaClaudeCodeRBACGroupStatusActive::class,
            'deleted' => BetaClaudeCodeRBACGroupStatusDeleted::class,
            'unknown' => BetaClaudeCodeRBACGroupStatusUnknown::class,
        ];
    }
}
