<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages\MessageBatch;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class ProcessingStatus implements ConverterSource
{
    use Enum;

    final public const IN_PROGRESS = 'in_progress';

    final public const CANCELING = 'canceling';

    final public const ENDED = 'ended';
}
