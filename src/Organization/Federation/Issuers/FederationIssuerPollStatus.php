<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Issuers;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Status of automatic JWKS polling for a federation issuer.
 *
 * Anthropic periodically fetches the issuer's signing keys in the
 * background. These fields summarize the most recent fetches so the
 * health of the JWKS endpoint can be monitored.
 *
 * @phpstan-type FederationIssuerPollStatusShape = array{
 *   consecutiveFailures: int,
 *   lastFetchedAt: \DateTimeInterface|null,
 *   nextPollAt: \DateTimeInterface|null,
 * }
 */
final class FederationIssuerPollStatus implements BaseModel
{
    /** @use SdkModel<FederationIssuerPollStatusShape> */
    use SdkModel;

    /**
     * Consecutive fetch failures since the last success.
     */
    #[Required('consecutive_failures')]
    public int $consecutiveFailures;

    /**
     * When the last successful fetch completed.
     */
    #[Required('last_fetched_at')]
    public ?\DateTimeInterface $lastFetchedAt;

    /**
     * When the next fetch is scheduled. Null if paused.
     */
    #[Required('next_poll_at')]
    public ?\DateTimeInterface $nextPollAt;

    /**
     * `new FederationIssuerPollStatus()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FederationIssuerPollStatus::with(
     *   consecutiveFailures: ..., lastFetchedAt: ..., nextPollAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FederationIssuerPollStatus())
     *   ->withConsecutiveFailures(...)
     *   ->withLastFetchedAt(...)
     *   ->withNextPollAt(...)
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
     */
    public static function with(
        int $consecutiveFailures,
        ?\DateTimeInterface $lastFetchedAt,
        ?\DateTimeInterface $nextPollAt,
    ): self {
        $self = new self;

        $self['consecutiveFailures'] = $consecutiveFailures;
        $self['lastFetchedAt'] = $lastFetchedAt;
        $self['nextPollAt'] = $nextPollAt;

        return $self;
    }

    /**
     * Consecutive fetch failures since the last success.
     */
    public function withConsecutiveFailures(int $consecutiveFailures): self
    {
        $self = clone $this;
        $self['consecutiveFailures'] = $consecutiveFailures;

        return $self;
    }

    /**
     * When the last successful fetch completed.
     */
    public function withLastFetchedAt(?\DateTimeInterface $lastFetchedAt): self
    {
        $self = clone $this;
        $self['lastFetchedAt'] = $lastFetchedAt;

        return $self;
    }

    /**
     * When the next fetch is scheduled. Null if paused.
     */
    public function withNextPollAt(?\DateTimeInterface $nextPollAt): self
    {
        $self = clone $this;
        $self['nextPollAt'] = $nextPollAt;

        return $self;
    }
}
