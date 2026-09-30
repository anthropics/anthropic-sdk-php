<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Office Agent activity metrics for a single user on a given day within one Office product.
 *
 * @phpstan-type AnalyticsOfficeProductMetricsShape = array{
 *   connectorsUsedCount: int,
 *   distinctConnectorsUsedCount: int|null,
 *   distinctSessionCount: int|null,
 *   distinctSkillsUsedCount: int|null,
 *   messageCount: int,
 *   skillsUsedCount: int,
 * }
 */
final class AnalyticsOfficeProductMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsOfficeProductMetricsShape> */
    use SdkModel;

    /**
     * Number of MCP connector invocations.
     */
    #[Required('connectors_used_count')]
    public int $connectorsUsedCount;

    /**
     * Number of distinct MCP connectors used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_connectors_used_count')]
    public ?int $distinctConnectorsUsedCount;

    /**
     * Number of distinct Office Agent sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_count')]
    public ?int $distinctSessionCount;

    /**
     * Number of distinct skills used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_skills_used_count')]
    public ?int $distinctSkillsUsedCount;

    /**
     * Number of messages sent.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * Number of skill invocations.
     */
    #[Required('skills_used_count')]
    public int $skillsUsedCount;

    /**
     * `new AnalyticsOfficeProductMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsOfficeProductMetrics::with(
     *   connectorsUsedCount: ...,
     *   distinctConnectorsUsedCount: ...,
     *   distinctSessionCount: ...,
     *   distinctSkillsUsedCount: ...,
     *   messageCount: ...,
     *   skillsUsedCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsOfficeProductMetrics)
     *   ->withConnectorsUsedCount(...)
     *   ->withDistinctConnectorsUsedCount(...)
     *   ->withDistinctSessionCount(...)
     *   ->withDistinctSkillsUsedCount(...)
     *   ->withMessageCount(...)
     *   ->withSkillsUsedCount(...)
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
        int $connectorsUsedCount,
        ?int $distinctConnectorsUsedCount,
        ?int $distinctSessionCount,
        ?int $distinctSkillsUsedCount,
        int $messageCount,
        int $skillsUsedCount,
    ): self {
        $self = new self;

        $self['connectorsUsedCount'] = $connectorsUsedCount;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;
        $self['distinctSessionCount'] = $distinctSessionCount;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;
        $self['messageCount'] = $messageCount;
        $self['skillsUsedCount'] = $skillsUsedCount;

        return $self;
    }

    /**
     * Number of MCP connector invocations.
     */
    public function withConnectorsUsedCount(int $connectorsUsedCount): self
    {
        $self = clone $this;
        $self['connectorsUsedCount'] = $connectorsUsedCount;

        return $self;
    }

    /**
     * Number of distinct MCP connectors used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConnectorsUsedCount(
        ?int $distinctConnectorsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;

        return $self;
    }

    /**
     * Number of distinct Office Agent sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionCount(?int $distinctSessionCount): self
    {
        $self = clone $this;
        $self['distinctSessionCount'] = $distinctSessionCount;

        return $self;
    }

    /**
     * Number of distinct skills used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSkillsUsedCount(
        ?int $distinctSkillsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;

        return $self;
    }

    /**
     * Number of messages sent.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Number of skill invocations.
     */
    public function withSkillsUsedCount(int $skillsUsedCount): self
    {
        $self = clone $this;
        $self['skillsUsedCount'] = $skillsUsedCount;

        return $self;
    }
}
