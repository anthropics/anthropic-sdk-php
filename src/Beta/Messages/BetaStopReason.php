<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_stop_reason_alias = BetaStopReason::*
 */
final class BetaStopReason implements ConverterSource
{
    use SdkEnum;

    public const END_TURN = 'end_turn';

    public const MAX_TOKENS = 'max_tokens';

    public const STOP_SEQUENCE = 'stop_sequence';

    public const TOOL_USE = 'tool_use';

    public const PAUSE_TURN = 'pause_turn';

    public const REFUSAL = 'refusal';
}
