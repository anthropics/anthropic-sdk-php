<?php

declare(strict_types=1);

namespace Anthropic\Lib\Threads;

use Anthropic\Beta\Messages\BetaMessage;

/**
 * The part of a reply that arrived before its stream ended early.
 *
 * @internal
 */
final class PartialReply
{
    public function __construct(public readonly BetaMessage $message) {}
}
