<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Cowork session activity recorded while members had Chat and Cowork
 * unified turned on.
 *
 * @phpstan-type AnalyticsChatCoworkUnifiedSessionsMetricsShape = array{
 *   actionCount: int,
 *   artifactsCreatedCount: int,
 *   connectorsUsedCount: int,
 *   dispatchTurnCount: int,
 *   distinctConnectorsUsedCount: int|null,
 *   distinctPluginsUsedCount: int|null,
 *   distinctSessionCount: int|null,
 *   distinctSkillsUsedCount: int|null,
 *   editToolCount: int|null,
 *   fileEditCount: int|null,
 *   messageCount: int,
 *   multiEditToolCount: int|null,
 *   notebookEditToolCount: int|null,
 *   pluginsUsedCount: int|null,
 *   sessionsWithFileEditsCount: int|null,
 *   skillsUsedCount: int,
 *   writeToolCount: int|null,
 * }
 */
final class AnalyticsChatCoworkUnifiedSessionsMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsChatCoworkUnifiedSessionsMetricsShape> */
    use SdkModel;

    /**
     * Same measure as `cowork_metrics.action_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('action_count')]
    public int $actionCount;

    /**
     * Same measure as `cowork_metrics.artifacts_created_count`, for activity recorded while members had Chat and Cowork unified turned on. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('artifacts_created_count')]
    public int $artifactsCreatedCount;

    /**
     * Same measure as `cowork_metrics.connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('connectors_used_count')]
    public int $connectorsUsedCount;

    /**
     * Same measure as `cowork_metrics.dispatch_turn_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('dispatch_turn_count')]
    public int $dispatchTurnCount;

    /**
     * Same measure as `cowork_metrics.distinct_connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_connectors_used_count')]
    public ?int $distinctConnectorsUsedCount;

    /**
     * Same measure as `cowork_metrics.distinct_plugins_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_plugins_used_count')]
    public ?int $distinctPluginsUsedCount;

    /**
     * Same measure as `cowork_metrics.distinct_session_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_count')]
    public ?int $distinctSessionCount;

    /**
     * Same measure as `cowork_metrics.distinct_skills_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_skills_used_count')]
    public ?int $distinctSkillsUsedCount;

    /**
     * Same measure as `cowork_metrics.edit_tool_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('edit_tool_count')]
    public ?int $editToolCount;

    /**
     * Same measure as `cowork_metrics.file_edit_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('file_edit_count')]
    public ?int $fileEditCount;

    /**
     * Same measure as `cowork_metrics.message_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * Same measure as `cowork_metrics.multi_edit_tool_count`, for activity recorded while members had Chat and Cowork unified turned on. Claude no longer has a multi-edit tool, so expect 0 when not null; each edit is now a separate Edit tool call, counted in `edit_tool_count` and `file_edit_count`.
     */
    #[Required('multi_edit_tool_count')]
    public ?int $multiEditToolCount;

    /**
     * Same measure as `cowork_metrics.notebook_edit_tool_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('notebook_edit_tool_count')]
    public ?int $notebookEditToolCount;

    /**
     * Same measure as `cowork_metrics.plugins_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('plugins_used_count')]
    public ?int $pluginsUsedCount;

    /**
     * Same measure as `cowork_metrics.sessions_with_file_edits_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('sessions_with_file_edits_count')]
    public ?int $sessionsWithFileEditsCount;

    /**
     * Same measure as `cowork_metrics.skills_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('skills_used_count')]
    public int $skillsUsedCount;

    /**
     * Same measure as `cowork_metrics.write_tool_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('write_tool_count')]
    public ?int $writeToolCount;

    /**
     * `new AnalyticsChatCoworkUnifiedSessionsMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsChatCoworkUnifiedSessionsMetrics::with(
     *   actionCount: ...,
     *   artifactsCreatedCount: ...,
     *   connectorsUsedCount: ...,
     *   dispatchTurnCount: ...,
     *   distinctConnectorsUsedCount: ...,
     *   distinctPluginsUsedCount: ...,
     *   distinctSessionCount: ...,
     *   distinctSkillsUsedCount: ...,
     *   editToolCount: ...,
     *   fileEditCount: ...,
     *   messageCount: ...,
     *   multiEditToolCount: ...,
     *   notebookEditToolCount: ...,
     *   pluginsUsedCount: ...,
     *   sessionsWithFileEditsCount: ...,
     *   skillsUsedCount: ...,
     *   writeToolCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsChatCoworkUnifiedSessionsMetrics())
     *   ->withActionCount(...)
     *   ->withArtifactsCreatedCount(...)
     *   ->withConnectorsUsedCount(...)
     *   ->withDispatchTurnCount(...)
     *   ->withDistinctConnectorsUsedCount(...)
     *   ->withDistinctPluginsUsedCount(...)
     *   ->withDistinctSessionCount(...)
     *   ->withDistinctSkillsUsedCount(...)
     *   ->withEditToolCount(...)
     *   ->withFileEditCount(...)
     *   ->withMessageCount(...)
     *   ->withMultiEditToolCount(...)
     *   ->withNotebookEditToolCount(...)
     *   ->withPluginsUsedCount(...)
     *   ->withSessionsWithFileEditsCount(...)
     *   ->withSkillsUsedCount(...)
     *   ->withWriteToolCount(...)
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
        ?int $distinctPluginsUsedCount,
        ?int $distinctSessionCount,
        ?int $distinctSkillsUsedCount,
        ?int $editToolCount,
        ?int $fileEditCount,
        int $messageCount,
        ?int $multiEditToolCount,
        ?int $notebookEditToolCount,
        ?int $pluginsUsedCount,
        ?int $sessionsWithFileEditsCount,
        int $skillsUsedCount,
        ?int $writeToolCount,
    ): self {
        $self = new self;

        $self['actionCount'] = $actionCount;
        $self['artifactsCreatedCount'] = $artifactsCreatedCount;
        $self['connectorsUsedCount'] = $connectorsUsedCount;
        $self['dispatchTurnCount'] = $dispatchTurnCount;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;
        $self['distinctPluginsUsedCount'] = $distinctPluginsUsedCount;
        $self['distinctSessionCount'] = $distinctSessionCount;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;
        $self['editToolCount'] = $editToolCount;
        $self['fileEditCount'] = $fileEditCount;
        $self['messageCount'] = $messageCount;
        $self['multiEditToolCount'] = $multiEditToolCount;
        $self['notebookEditToolCount'] = $notebookEditToolCount;
        $self['pluginsUsedCount'] = $pluginsUsedCount;
        $self['sessionsWithFileEditsCount'] = $sessionsWithFileEditsCount;
        $self['skillsUsedCount'] = $skillsUsedCount;
        $self['writeToolCount'] = $writeToolCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.action_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withActionCount(int $actionCount): self
    {
        $self = clone $this;
        $self['actionCount'] = $actionCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.artifacts_created_count`, for activity recorded while members had Chat and Cowork unified turned on. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withArtifactsCreatedCount(int $artifactsCreatedCount): self
    {
        $self = clone $this;
        $self['artifactsCreatedCount'] = $artifactsCreatedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withConnectorsUsedCount(int $connectorsUsedCount): self
    {
        $self = clone $this;
        $self['connectorsUsedCount'] = $connectorsUsedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.dispatch_turn_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withDispatchTurnCount(int $dispatchTurnCount): self
    {
        $self = clone $this;
        $self['dispatchTurnCount'] = $dispatchTurnCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.distinct_connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConnectorsUsedCount(
        ?int $distinctConnectorsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.distinct_plugins_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctPluginsUsedCount(
        ?int $distinctPluginsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctPluginsUsedCount'] = $distinctPluginsUsedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.distinct_session_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionCount(?int $distinctSessionCount): self
    {
        $self = clone $this;
        $self['distinctSessionCount'] = $distinctSessionCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.distinct_skills_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSkillsUsedCount(
        ?int $distinctSkillsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.edit_tool_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withEditToolCount(?int $editToolCount): self
    {
        $self = clone $this;
        $self['editToolCount'] = $editToolCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.file_edit_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withFileEditCount(?int $fileEditCount): self
    {
        $self = clone $this;
        $self['fileEditCount'] = $fileEditCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.message_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.multi_edit_tool_count`, for activity recorded while members had Chat and Cowork unified turned on. Claude no longer has a multi-edit tool, so expect 0 when not null; each edit is now a separate Edit tool call, counted in `edit_tool_count` and `file_edit_count`.
     */
    public function withMultiEditToolCount(?int $multiEditToolCount): self
    {
        $self = clone $this;
        $self['multiEditToolCount'] = $multiEditToolCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.notebook_edit_tool_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withNotebookEditToolCount(?int $notebookEditToolCount): self
    {
        $self = clone $this;
        $self['notebookEditToolCount'] = $notebookEditToolCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.plugins_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withPluginsUsedCount(?int $pluginsUsedCount): self
    {
        $self = clone $this;
        $self['pluginsUsedCount'] = $pluginsUsedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.sessions_with_file_edits_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withSessionsWithFileEditsCount(
        ?int $sessionsWithFileEditsCount
    ): self {
        $self = clone $this;
        $self['sessionsWithFileEditsCount'] = $sessionsWithFileEditsCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.skills_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withSkillsUsedCount(int $skillsUsedCount): self
    {
        $self = clone $this;
        $self['skillsUsedCount'] = $skillsUsedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.write_tool_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withWriteToolCount(?int $writeToolCount): self
    {
        $self = clone $this;
        $self['writeToolCount'] = $writeToolCount;

        return $self;
    }
}
