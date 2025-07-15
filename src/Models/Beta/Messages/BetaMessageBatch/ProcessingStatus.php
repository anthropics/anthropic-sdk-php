<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages\BetaMessageBatch;

final class ProcessingStatus
{
    final public const IN_PROGRESS = 'in_progress';

    final public const CANCELING = 'canceling';

    final public const ENDED = 'ended';
}
