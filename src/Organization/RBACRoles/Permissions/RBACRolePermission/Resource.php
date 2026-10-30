<?php

declare(strict_types=1);

namespace Anthropic\Organization\RBACRoles\Permissions\RBACRolePermission;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\RBACRoles\Permissions\RBACAllConnectorsPermissionResource;
use Anthropic\Organization\RBACRoles\Permissions\RBACConnectorPermissionResource;
use Anthropic\Organization\RBACRoles\Permissions\RBACConnectorScopePermissionResource;
use Anthropic\Organization\RBACRoles\Permissions\RBACConnectorToolPermissionResource;
use Anthropic\Organization\RBACRoles\Permissions\RBACOrganizationPermissionResource;

/**
 * What the permission applies to.
 *
 * A tagged union: `type` names the kind of resource and determines which
 * identifier fields are present.
 *
 * @phpstan-import-type RBACOrganizationPermissionResourceShape from \Anthropic\Organization\RBACRoles\Permissions\RBACOrganizationPermissionResource
 * @phpstan-import-type RBACConnectorToolPermissionResourceShape from \Anthropic\Organization\RBACRoles\Permissions\RBACConnectorToolPermissionResource
 * @phpstan-import-type RBACConnectorScopePermissionResourceShape from \Anthropic\Organization\RBACRoles\Permissions\RBACConnectorScopePermissionResource
 * @phpstan-import-type RBACConnectorPermissionResourceShape from \Anthropic\Organization\RBACRoles\Permissions\RBACConnectorPermissionResource
 * @phpstan-import-type RBACAllConnectorsPermissionResourceShape from \Anthropic\Organization\RBACRoles\Permissions\RBACAllConnectorsPermissionResource
 *
 * @phpstan-type ResourceVariants = RBACOrganizationPermissionResource|RBACConnectorToolPermissionResource|RBACConnectorScopePermissionResource|RBACConnectorPermissionResource|RBACAllConnectorsPermissionResource
 * @phpstan-type ResourceShape = ResourceVariants|RBACOrganizationPermissionResourceShape|RBACConnectorToolPermissionResourceShape|RBACConnectorScopePermissionResourceShape|RBACConnectorPermissionResourceShape|RBACAllConnectorsPermissionResourceShape
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
            'organization' => RBACOrganizationPermissionResource::class,
            'connector_tool' => RBACConnectorToolPermissionResource::class,
            'connector_scope' => RBACConnectorScopePermissionResource::class,
            'connector' => RBACConnectorPermissionResource::class,
            'all_connectors' => RBACAllConnectorsPermissionResource::class,
        ];
    }
}
