<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys\APIKey;

use Anthropic\Beta\Organization\APIKeys\APIKey\Scope\Type;
use Anthropic\Beta\Organization\APIKeys\APIKeyOrganizationScope;
use Anthropic\Beta\Organization\APIKeys\APIKeyWorkspaceScope;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Where the API key belongs: its Workspace (`{"type": "workspace", "workspace_id": "wrkspc_..."}`, with the Workspace's real ID even when it is the organization's default Workspace), or the organization (`{"type": "organization"}`) for a principal-bound API key that has no Workspace.
 *
 * @phpstan-import-type APIKeyOrganizationScopeShape from \Anthropic\Beta\Organization\APIKeys\APIKeyOrganizationScope
 * @phpstan-import-type APIKeyWorkspaceScopeShape from \Anthropic\Beta\Organization\APIKeys\APIKeyWorkspaceScope
 *
 * @phpstan-type ScopeVariants = APIKeyOrganizationScope|APIKeyWorkspaceScope
 * @phpstan-type ScopeShape = ScopeVariants|APIKeyOrganizationScopeShape|APIKeyWorkspaceScopeShape
 */
final class Scope implements ConverterSource
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
            'organization' => APIKeyOrganizationScope::class,
            'workspace' => APIKeyWorkspaceScope::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ORGANIZATION|'organization' ? APIKeyOrganizationScope : ($type is Type::WORKSPACE|'workspace' ? APIKeyWorkspaceScope : APIKeyOrganizationScope|APIKeyWorkspaceScope))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $workspaceID = null
    ): APIKeyOrganizationScope|APIKeyWorkspaceScope {
        return match ($type) {
            Type::ORGANIZATION, 'organization' => APIKeyOrganizationScope::with(),
            Type::WORKSPACE, 'workspace' => APIKeyWorkspaceScope::with(
                workspaceID: $workspaceID ?? throw new \ArgumentCountError('$workspaceID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
