<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Cowork activity metrics for a single user on a given day.
 *
 * @phpstan-type AnalyticsCoworkMetricsShape = array{
 *   actionCount: int,
 *   artifactsCreatedCount: int,
 *   connectorsUsedCount: int,
 *   dispatchTurnCount: int,
 *   distinctConnectorsUsedCount: int|null,
 *   distinctSessionCount: int|null,
 *   distinctSkillsUsedCount: int|null,
 *   messageCount: int,
 *   skillsUsedCount: int,
 *   distinctPluginsUsedCount?: int|null,
 *   editToolCount?: int|null,
 *   fileEditCount?: int|null,
 *   multiEditToolCount?: int|null,
 *   notebookEditToolCount?: int|null,
 *   pluginsUsedCount?: int|null,
 *   sessionsWithFileEditsCount?: int|null,
 *   writeToolCount?: int|null,
 * }
 */
final class AnalyticsCoworkMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsCoworkMetricsShape> */
    use SdkModel;

    /**
     * Number of tool actions completed in Cowork sessions.
     */
    #[Required('action_count')]
    public int $actionCount;

    /**
     * Number of artifacts created in Cowork sessions: an artifact counts once, on the day a session first saves it. Counted from 2026-08-17; 0 on earlier days. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('artifacts_created_count')]
    public int $artifactsCreatedCount;

    /**
     * Total number of connector invocations in Cowork sessions.
     */
    #[Required('connectors_used_count')]
    public int $connectorsUsedCount;

    /**
     * Number of Dispatch (background agent) turns completed.
     */
    #[Required('dispatch_turn_count')]
    public int $dispatchTurnCount;

    /**
     * Number of distinct connectors used in Cowork sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_connectors_used_count')]
    public ?int $distinctConnectorsUsedCount;

    /**
     * Number of distinct Cowork sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_count')]
    public ?int $distinctSessionCount;

    /**
     * Number of distinct skills used in Cowork sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_skills_used_count')]
    public ?int $distinctSkillsUsedCount;

    /**
     * Number of messages sent in Cowork sessions.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * Total number of skill invocations in Cowork sessions.
     */
    #[Required('skills_used_count')]
    public int $skillsUsedCount;

    /**
     * Number of distinct plugins used in Cowork sessions. Null while Cowork plugin-use metrics are not enabled for this organization. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Optional('distinct_plugins_used_count', nullable: true)]
    public ?int $distinctPluginsUsedCount;

    /**
     * Number of successful Edit tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    #[Optional('edit_tool_count', nullable: true)]
    public ?int $editToolCount;

    /**
     * Number of successful file-edit tool calls (Edit, MultiEdit, Write, NotebookEdit) in Cowork sessions. Null, never 0, while the file-edit metrics are not enabled for this organization.
     */
    #[Optional('file_edit_count', nullable: true)]
    public ?int $fileEditCount;

    /**
     * Number of successful MultiEdit tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    #[Optional('multi_edit_tool_count', nullable: true)]
    public ?int $multiEditToolCount;

    /**
     * Number of successful NotebookEdit tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    #[Optional('notebook_edit_tool_count', nullable: true)]
    public ?int $notebookEditToolCount;

    /**
     * Total number of plugin invocations in Cowork sessions. Null while Cowork plugin-use metrics are not enabled for this organization.
     */
    #[Optional('plugins_used_count', nullable: true)]
    public ?int $pluginsUsedCount;

    /**
     * Number of distinct Cowork sessions with at least one successful file-edit tool call. Null while the file-edit metrics are not enabled for this organization. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Optional('sessions_with_file_edits_count', nullable: true)]
    public ?int $sessionsWithFileEditsCount;

    /**
     * Number of successful Write tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    #[Optional('write_tool_count', nullable: true)]
    public ?int $writeToolCount;

    /**
     * `new AnalyticsCoworkMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsCoworkMetrics::with(
     *   actionCount: ...,
     *   artifactsCreatedCount: ...,
     *   connectorsUsedCount: ...,
     *   dispatchTurnCount: ...,
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
     * (new AnalyticsCoworkMetrics)
     *   ->withActionCount(...)
     *   ->withArtifactsCreatedCount(...)
     *   ->withConnectorsUsedCount(...)
     *   ->withDispatchTurnCount(...)
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
        int $actionCount,
        int $artifactsCreatedCount,
        int $connectorsUsedCount,
        int $dispatchTurnCount,
        ?int $distinctConnectorsUsedCount,
        ?int $distinctSessionCount,
        ?int $distinctSkillsUsedCount,
        int $messageCount,
        int $skillsUsedCount,
        ?int $distinctPluginsUsedCount = null,
        ?int $editToolCount = null,
        ?int $fileEditCount = null,
        ?int $multiEditToolCount = null,
        ?int $notebookEditToolCount = null,
        ?int $pluginsUsedCount = null,
        ?int $sessionsWithFileEditsCount = null,
        ?int $writeToolCount = null,
    ): self {
        $self = new self;

        $self['actionCount'] = $actionCount;
        $self['artifactsCreatedCount'] = $artifactsCreatedCount;
        $self['connectorsUsedCount'] = $connectorsUsedCount;
        $self['dispatchTurnCount'] = $dispatchTurnCount;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;
        $self['distinctSessionCount'] = $distinctSessionCount;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;
        $self['messageCount'] = $messageCount;
        $self['skillsUsedCount'] = $skillsUsedCount;

        null !== $distinctPluginsUsedCount && $self['distinctPluginsUsedCount'] = $distinctPluginsUsedCount;
        null !== $editToolCount && $self['editToolCount'] = $editToolCount;
        null !== $fileEditCount && $self['fileEditCount'] = $fileEditCount;
        null !== $multiEditToolCount && $self['multiEditToolCount'] = $multiEditToolCount;
        null !== $notebookEditToolCount && $self['notebookEditToolCount'] = $notebookEditToolCount;
        null !== $pluginsUsedCount && $self['pluginsUsedCount'] = $pluginsUsedCount;
        null !== $sessionsWithFileEditsCount && $self['sessionsWithFileEditsCount'] = $sessionsWithFileEditsCount;
        null !== $writeToolCount && $self['writeToolCount'] = $writeToolCount;

        return $self;
    }

    /**
     * Number of tool actions completed in Cowork sessions.
     */
    public function withActionCount(int $actionCount): self
    {
        $self = clone $this;
        $self['actionCount'] = $actionCount;

        return $self;
    }

    /**
     * Number of artifacts created in Cowork sessions: an artifact counts once, on the day a session first saves it. Counted from 2026-08-17; 0 on earlier days. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withArtifactsCreatedCount(int $artifactsCreatedCount): self
    {
        $self = clone $this;
        $self['artifactsCreatedCount'] = $artifactsCreatedCount;

        return $self;
    }

    /**
     * Total number of connector invocations in Cowork sessions.
     */
    public function withConnectorsUsedCount(int $connectorsUsedCount): self
    {
        $self = clone $this;
        $self['connectorsUsedCount'] = $connectorsUsedCount;

        return $self;
    }

    /**
     * Number of Dispatch (background agent) turns completed.
     */
    public function withDispatchTurnCount(int $dispatchTurnCount): self
    {
        $self = clone $this;
        $self['dispatchTurnCount'] = $dispatchTurnCount;

        return $self;
    }

    /**
     * Number of distinct connectors used in Cowork sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConnectorsUsedCount(
        ?int $distinctConnectorsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;

        return $self;
    }

    /**
     * Number of distinct Cowork sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionCount(?int $distinctSessionCount): self
    {
        $self = clone $this;
        $self['distinctSessionCount'] = $distinctSessionCount;

        return $self;
    }

    /**
     * Number of distinct skills used in Cowork sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSkillsUsedCount(
        ?int $distinctSkillsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;

        return $self;
    }

    /**
     * Number of messages sent in Cowork sessions.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Total number of skill invocations in Cowork sessions.
     */
    public function withSkillsUsedCount(int $skillsUsedCount): self
    {
        $self = clone $this;
        $self['skillsUsedCount'] = $skillsUsedCount;

        return $self;
    }

    /**
     * Number of distinct plugins used in Cowork sessions. Null while Cowork plugin-use metrics are not enabled for this organization. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctPluginsUsedCount(
        ?int $distinctPluginsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctPluginsUsedCount'] = $distinctPluginsUsedCount;

        return $self;
    }

    /**
     * Number of successful Edit tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    public function withEditToolCount(?int $editToolCount): self
    {
        $self = clone $this;
        $self['editToolCount'] = $editToolCount;

        return $self;
    }

    /**
     * Number of successful file-edit tool calls (Edit, MultiEdit, Write, NotebookEdit) in Cowork sessions. Null, never 0, while the file-edit metrics are not enabled for this organization.
     */
    public function withFileEditCount(?int $fileEditCount): self
    {
        $self = clone $this;
        $self['fileEditCount'] = $fileEditCount;

        return $self;
    }

    /**
     * Number of successful MultiEdit tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    public function withMultiEditToolCount(?int $multiEditToolCount): self
    {
        $self = clone $this;
        $self['multiEditToolCount'] = $multiEditToolCount;

        return $self;
    }

    /**
     * Number of successful NotebookEdit tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    public function withNotebookEditToolCount(?int $notebookEditToolCount): self
    {
        $self = clone $this;
        $self['notebookEditToolCount'] = $notebookEditToolCount;

        return $self;
    }

    /**
     * Total number of plugin invocations in Cowork sessions. Null while Cowork plugin-use metrics are not enabled for this organization.
     */
    public function withPluginsUsedCount(?int $pluginsUsedCount): self
    {
        $self = clone $this;
        $self['pluginsUsedCount'] = $pluginsUsedCount;

        return $self;
    }

    /**
     * Number of distinct Cowork sessions with at least one successful file-edit tool call. Null while the file-edit metrics are not enabled for this organization. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withSessionsWithFileEditsCount(
        ?int $sessionsWithFileEditsCount
    ): self {
        $self = clone $this;
        $self['sessionsWithFileEditsCount'] = $sessionsWithFileEditsCount;

        return $self;
    }

    /**
     * Number of successful Write tool calls in Cowork sessions. Null while the file-edit metrics are not enabled for this organization.
     */
    public function withWriteToolCount(?int $writeToolCount): self
    {
        $self = clone $this;
        $self['writeToolCount'] = $writeToolCount;

        return $self;
    }
}
