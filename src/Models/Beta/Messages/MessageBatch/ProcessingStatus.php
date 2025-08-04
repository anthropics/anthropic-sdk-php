<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages\MessageBatch;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Processing status of the Message Batch.
 *
 * @phpstan-type processing_status_alias = ProcessingStatus::*
 */
final class ProcessingStatus implements ConverterSource
{
    use Enum;

    public const IN_PROGRESS = 'in_progress';

    public const CANCELING = 'canceling';

    public const ENDED = 'ended';
}
