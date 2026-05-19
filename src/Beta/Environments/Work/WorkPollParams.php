<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
 *
 * Long poll for work items in the queue.
 *
 * @see Anthropic\Services\Beta\Environments\WorkService::poll()
 *
 * @phpstan-type WorkPollParamsShape = array{
 *   blockMs?: int|null,
 *   reclaimOlderThanMs?: int|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   anthropicWorkerID?: string|null,
 * }
 */
final class WorkPollParams implements BaseModel
{
    /** @use SdkModel<WorkPollParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * How long to wait for work to arrive before returning. Must be 1-999 in milliseconds. Defaults to non-blocking (returns immediately if no work is available).
     */
    #[Optional(nullable: true)]
    public ?int $blockMs;

    /**
     * Reclaim unacknowledged work items older than this many milliseconds. If omitted, uses the default (5000ms).
     */
    #[Optional(nullable: true)]
    public ?int $reclaimOlderThanMs;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * Unique identifier for the specific worker polling, used to track aggregated environment-level work metrics in Console.
     */
    #[Optional]
    public ?string $anthropicWorkerID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $blockMs = null,
        ?int $reclaimOlderThanMs = null,
        ?array $betas = null,
        ?string $anthropicWorkerID = null,
    ): self {
        $self = new self;

        null !== $blockMs && $self['blockMs'] = $blockMs;
        null !== $reclaimOlderThanMs && $self['reclaimOlderThanMs'] = $reclaimOlderThanMs;
        null !== $betas && $self['betas'] = $betas;
        null !== $anthropicWorkerID && $self['anthropicWorkerID'] = $anthropicWorkerID;

        return $self;
    }

    /**
     * How long to wait for work to arrive before returning. Must be 1-999 in milliseconds. Defaults to non-blocking (returns immediately if no work is available).
     */
    public function withBlockMs(?int $blockMs): self
    {
        $self = clone $this;
        $self['blockMs'] = $blockMs;

        return $self;
    }

    /**
     * Reclaim unacknowledged work items older than this many milliseconds. If omitted, uses the default (5000ms).
     */
    public function withReclaimOlderThanMs(?int $reclaimOlderThanMs): self
    {
        $self = clone $this;
        $self['reclaimOlderThanMs'] = $reclaimOlderThanMs;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }

    /**
     * Unique identifier for the specific worker polling, used to track aggregated environment-level work metrics in Console.
     */
    public function withAnthropicWorkerID(string $anthropicWorkerID): self
    {
        $self = clone $this;
        $self['anthropicWorkerID'] = $anthropicWorkerID;

        return $self;
    }
}
