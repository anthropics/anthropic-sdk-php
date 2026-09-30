<?php

declare(strict_types=1);

namespace Anthropic\Organization\APIKeys\APIKey;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\APIKeys\APIKeyOrganizationScope;
use Anthropic\Organization\APIKeys\APIKeyWorkspaceScope;

/**
 * Where the API key belongs: its Workspace (`{"type": "workspace", "workspace_id": "wrkspc_..."}`, with the Workspace's real ID even when it is the organization's default Workspace), or the organization (`{"type": "organization"}`) for a principal-bound API key that has no Workspace.
 *
 * @phpstan-import-type APIKeyOrganizationScopeShape from \Anthropic\Organization\APIKeys\APIKeyOrganizationScope
 * @phpstan-import-type APIKeyWorkspaceScopeShape from \Anthropic\Organization\APIKeys\APIKeyWorkspaceScope
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
}
