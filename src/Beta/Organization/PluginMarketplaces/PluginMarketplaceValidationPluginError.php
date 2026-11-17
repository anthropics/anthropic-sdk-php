<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

// Loading the class registers this name as its alias.
class_exists(PluginMarketplaceValidationPluginErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated PluginMarketplaceValidationPluginError has been renamed to PluginMarketplaceValidationPluginErrorObject
     */
    class PluginMarketplaceValidationPluginError extends PluginMarketplaceValidationPluginErrorObject {}
}
