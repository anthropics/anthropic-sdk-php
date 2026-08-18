<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\MessageBatchResult;

enum Type: string
{
    case SUCCEEDED = 'succeeded';

    case ERRORED = 'errored';

    case CANCELED = 'canceled';

    case EXPIRED = 'expired';
}
