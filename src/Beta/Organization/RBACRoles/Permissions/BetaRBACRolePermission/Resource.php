<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission;

use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACAllConnectorsPermissionResource;
use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACConnectorPermissionResource;
use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACConnectorScopePermissionResource;
use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACConnectorToolPermissionResource;
use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACOrganizationPermissionResource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * What the permission applies to.
 *
 * A tagged union: `type` names the kind of resource and determines which
 * identifier fields are present.
 *
 * @phpstan-import-type BetaRBACOrganizationPermissionResourceShape from \Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACOrganizationPermissionResource
 * @phpstan-import-type BetaRBACConnectorToolPermissionResourceShape from \Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACConnectorToolPermissionResource
 * @phpstan-import-type BetaRBACConnectorScopePermissionResourceShape from \Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACConnectorScopePermissionResource
 * @phpstan-import-type BetaRBACConnectorPermissionResourceShape from \Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACConnectorPermissionResource
 * @phpstan-import-type BetaRBACAllConnectorsPermissionResourceShape from \Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACAllConnectorsPermissionResource
 *
 * @phpstan-type ResourceVariants = BetaRBACOrganizationPermissionResource|BetaRBACConnectorToolPermissionResource|BetaRBACConnectorScopePermissionResource|BetaRBACConnectorPermissionResource|BetaRBACAllConnectorsPermissionResource
 * @phpstan-type ResourceShape = ResourceVariants|BetaRBACOrganizationPermissionResourceShape|BetaRBACConnectorToolPermissionResourceShape|BetaRBACConnectorScopePermissionResourceShape|BetaRBACConnectorPermissionResourceShape|BetaRBACAllConnectorsPermissionResourceShape
 */
final class Resource implements ConverterSource
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
            'organization' => BetaRBACOrganizationPermissionResource::class,
            'connector_tool' => BetaRBACConnectorToolPermissionResource::class,
            'connector_scope' => BetaRBACConnectorScopePermissionResource::class,
            'connector' => BetaRBACConnectorPermissionResource::class,
            'all_connectors' => BetaRBACAllConnectorsPermissionResource::class,
        ];
    }
}
