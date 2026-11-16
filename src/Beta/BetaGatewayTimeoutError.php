<?php

declare(strict_types=1);

namespace Anthropic\Beta;

// Loading the class registers this name as its alias.
class_exists(BetaGatewayTimeoutErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaGatewayTimeoutError has been renamed to BetaGatewayTimeoutErrorObject
     */
    class BetaGatewayTimeoutError extends BetaGatewayTimeoutErrorObject {}
}
