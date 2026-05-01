<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tools;

/**
 * Thrown when an MCP value cannot be converted to a format supported by the Claude API.
 */
final class UnsupportedMCPValueError extends \RuntimeException {}
