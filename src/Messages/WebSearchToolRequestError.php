<?php

declare(strict_types=1);

namespace Anthropic\Messages;

// Loading the class registers this name as its alias.
class_exists(WebSearchToolRequestErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated WebSearchToolRequestError has been renamed to WebSearchToolRequestErrorObject
     */
    class WebSearchToolRequestError extends WebSearchToolRequestErrorObject {}
}
