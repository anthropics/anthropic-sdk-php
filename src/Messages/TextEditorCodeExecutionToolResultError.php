<?php

declare(strict_types=1);

namespace Anthropic\Messages;

// Loading the class registers this name as its alias.
class_exists(TextEditorCodeExecutionToolResultErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated TextEditorCodeExecutionToolResultError has been renamed to TextEditorCodeExecutionToolResultErrorObject
     */
    class TextEditorCodeExecutionToolResultError extends TextEditorCodeExecutionToolResultErrorObject {}
}
