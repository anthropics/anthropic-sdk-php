<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
 *
 * Record a heartbeat for a work item to maintain the lease.
 *
 * @see Anthropic\Services\Beta\Environments\WorkService::heartbeat()
 *
 * @phpstan-type WorkHeartbeatParamsShape = array{
 *   environmentID: string,
 *   desiredTTLSeconds?: int|null,
 *   expectedLastHeartbeat?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WorkHeartbeatParams implements BaseModel
{
    /** @use SdkModel<WorkHeartbeatParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $environmentID;

    /**
     * Desired TTL in seconds.
     */
    #[Optional(nullable: true)]
    public ?int $desiredTTLSeconds;

    /**
     * Expected last_heartbeat for conditional update (optimistic concurrency). Use literal 'NO_HEARTBEAT' to claim an unclaimed lease (first heartbeat). For subsequent heartbeats, echo the server's previous last_heartbeat value exactly. Returns 412 Precondition Failed if the actual value doesn't match.
     */
    #[Optional(nullable: true)]
    public ?string $expectedLastHeartbeat;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new WorkHeartbeatParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkHeartbeatParams::with(environmentID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkHeartbeatParams)->withEnvironmentID(...)
     * ```
     */
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
        string $environmentID,
        ?int $desiredTTLSeconds = null,
        ?string $expectedLastHeartbeat = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['environmentID'] = $environmentID;

        null !== $desiredTTLSeconds && $self['desiredTTLSeconds'] = $desiredTTLSeconds;
        null !== $expectedLastHeartbeat && $self['expectedLastHeartbeat'] = $expectedLastHeartbeat;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * Desired TTL in seconds.
     */
    public function withDesiredTTLSeconds(?int $desiredTTLSeconds): self
    {
        $self = clone $this;
        $self['desiredTTLSeconds'] = $desiredTTLSeconds;

        return $self;
    }

    /**
     * Expected last_heartbeat for conditional update (optimistic concurrency). Use literal 'NO_HEARTBEAT' to claim an unclaimed lease (first heartbeat). For subsequent heartbeats, echo the server's previous last_heartbeat value exactly. Returns 412 Precondition Failed if the actual value doesn't match.
     */
    public function withExpectedLastHeartbeat(
        ?string $expectedLastHeartbeat
    ): self {
        $self = clone $this;
        $self['expectedLastHeartbeat'] = $expectedLastHeartbeat;

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
}
