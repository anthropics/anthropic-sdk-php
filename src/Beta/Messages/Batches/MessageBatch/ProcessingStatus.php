<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\MessageBatch;

/**
 * Processing status of the Message Batch.
 */
enum ProcessingStatus: string
{
    case IN_PROGRESS = 'in_progress';

    case CANCELING = 'canceling';

    case ENDED = 'ended';
}
