<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

/**
 * Where a dream is in its lifecycle.
 *
 * `completed`, `failed`, and `canceled` are final: once a dream has one of these statuses, its status doesn't change again.
 *
 * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#lifecycle) for what each status means.
 */
enum BetaDreamStatus: string
{
    /**
     * The dream is waiting to start and hasn't read its inputs yet.
     *
     * `outputs` is empty and every `usage` count is zero.
     */
    case PENDING = 'pending';

    /**
     * The dream is reading its inputs and writing its result.
     *
     * `usage` updates while the dream has this status.
     */
    case RUNNING = 'running';

    /**
     * The dream finished and its output memory store holds the complete result.
     */
    case COMPLETED = 'completed';

    /**
     * The dream stopped with an error, which `error` describes.
     *
     * If `outputs` references a memory store, that memory store keeps what the dream wrote before it stopped.
     */
    case FAILED = 'failed';

    /**
     * A cancel request stopped the dream before it reached `completed` or `failed`.
     *
     * If `outputs` references a memory store, that memory store keeps what the dream wrote. `usage` can keep changing after the cancel.
     */
    case CANCELED = 'canceled';
}
