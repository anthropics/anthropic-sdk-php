<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages\MessageBatch;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class ProcessingStatus implements StaticConverter
{
    use Enum;

    final public const IN_PROGRESS = 'in_progress';

    final public const CANCELING = 'canceling';

    final public const ENDED = 'ended';
}

ProcessingStatus::__introspect();
