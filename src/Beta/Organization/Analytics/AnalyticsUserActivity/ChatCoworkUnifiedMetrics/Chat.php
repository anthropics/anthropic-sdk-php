<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsUserActivity\ChatCoworkUnifiedMetrics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Chat activity recorded while members had Chat and Cowork unified turned
 * on.
 *
 * @phpstan-type ChatShape = array{
 *   connectorsUsedCount: int,
 *   distinctArtifactsCreatedCount: int,
 *   distinctConnectorsUsedCount: int|null,
 *   distinctConversationCount: int|null,
 *   distinctFilesUploadedCount: int|null,
 *   distinctProjectsCreatedCount: int,
 *   distinctProjectsUsedCount: int|null,
 *   distinctSharedArtifactsViewedCount: int|null,
 *   distinctSkillsUsedCount: int|null,
 *   messageCount: int,
 *   sharedConversationsViewedCount: int,
 *   thinkingMessageCount: int,
 * }
 */
final class Chat implements BaseModel
{
    /** @use SdkModel<ChatShape> */
    use SdkModel;

    /**
     * Same measure as `chat_metrics.connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('connectors_used_count')]
    public int $connectorsUsedCount;

    /**
     * Same measure as `chat_metrics.distinct_artifacts_created_count`, for activity recorded while members had Chat and Cowork unified turned on. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('distinct_artifacts_created_count')]
    public int $distinctArtifactsCreatedCount;

    /**
     * Same measure as `chat_metrics.distinct_connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_connectors_used_count')]
    public ?int $distinctConnectorsUsedCount;

    /**
     * Same measure as `chat_metrics.distinct_conversation_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_conversation_count')]
    public ?int $distinctConversationCount;

    /**
     * Same measure as `chat_metrics.distinct_files_uploaded_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_files_uploaded_count')]
    public ?int $distinctFilesUploadedCount;

    /**
     * Same measure as `chat_metrics.distinct_projects_created_count`, for activity recorded while members had Chat and Cowork unified turned on. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('distinct_projects_created_count')]
    public int $distinctProjectsCreatedCount;

    /**
     * Same measure as `chat_metrics.distinct_projects_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_projects_used_count')]
    public ?int $distinctProjectsUsedCount;

    /**
     * Always null: shared-artifact views are not currently measured.
     */
    #[Required('distinct_shared_artifacts_viewed_count')]
    public ?int $distinctSharedArtifactsViewedCount;

    /**
     * Same measure as `chat_metrics.distinct_skills_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_skills_used_count')]
    public ?int $distinctSkillsUsedCount;

    /**
     * Same measure as `chat_metrics.message_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * Same measure as `chat_metrics.shared_conversations_viewed_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('shared_conversations_viewed_count')]
    public int $sharedConversationsViewedCount;

    /**
     * Same measure as `chat_metrics.thinking_message_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    #[Required('thinking_message_count')]
    public int $thinkingMessageCount;

    /**
     * `new Chat()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Chat::with(
     *   connectorsUsedCount: ...,
     *   distinctArtifactsCreatedCount: ...,
     *   distinctConnectorsUsedCount: ...,
     *   distinctConversationCount: ...,
     *   distinctFilesUploadedCount: ...,
     *   distinctProjectsCreatedCount: ...,
     *   distinctProjectsUsedCount: ...,
     *   distinctSharedArtifactsViewedCount: ...,
     *   distinctSkillsUsedCount: ...,
     *   messageCount: ...,
     *   sharedConversationsViewedCount: ...,
     *   thinkingMessageCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Chat())
     *   ->withConnectorsUsedCount(...)
     *   ->withDistinctArtifactsCreatedCount(...)
     *   ->withDistinctConnectorsUsedCount(...)
     *   ->withDistinctConversationCount(...)
     *   ->withDistinctFilesUploadedCount(...)
     *   ->withDistinctProjectsCreatedCount(...)
     *   ->withDistinctProjectsUsedCount(...)
     *   ->withDistinctSharedArtifactsViewedCount(...)
     *   ->withDistinctSkillsUsedCount(...)
     *   ->withMessageCount(...)
     *   ->withSharedConversationsViewedCount(...)
     *   ->withThinkingMessageCount(...)
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
        int $distinctArtifactsCreatedCount,
        ?int $distinctConnectorsUsedCount,
        ?int $distinctConversationCount,
        ?int $distinctFilesUploadedCount,
        int $distinctProjectsCreatedCount,
        ?int $distinctProjectsUsedCount,
        ?int $distinctSharedArtifactsViewedCount,
        ?int $distinctSkillsUsedCount,
        int $messageCount,
        int $sharedConversationsViewedCount,
        int $thinkingMessageCount,
    ): self {
        $self = new self;

        $self['connectorsUsedCount'] = $connectorsUsedCount;
        $self['distinctArtifactsCreatedCount'] = $distinctArtifactsCreatedCount;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;
        $self['distinctConversationCount'] = $distinctConversationCount;
        $self['distinctFilesUploadedCount'] = $distinctFilesUploadedCount;
        $self['distinctProjectsCreatedCount'] = $distinctProjectsCreatedCount;
        $self['distinctProjectsUsedCount'] = $distinctProjectsUsedCount;
        $self['distinctSharedArtifactsViewedCount'] = $distinctSharedArtifactsViewedCount;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;
        $self['messageCount'] = $messageCount;
        $self['sharedConversationsViewedCount'] = $sharedConversationsViewedCount;
        $self['thinkingMessageCount'] = $thinkingMessageCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withConnectorsUsedCount(int $connectorsUsedCount): self
    {
        $self = clone $this;
        $self['connectorsUsedCount'] = $connectorsUsedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_artifacts_created_count`, for activity recorded while members had Chat and Cowork unified turned on. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withDistinctArtifactsCreatedCount(
        int $distinctArtifactsCreatedCount
    ): self {
        $self = clone $this;
        $self['distinctArtifactsCreatedCount'] = $distinctArtifactsCreatedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_connectors_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConnectorsUsedCount(
        ?int $distinctConnectorsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_conversation_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConversationCount(
        ?int $distinctConversationCount
    ): self {
        $self = clone $this;
        $self['distinctConversationCount'] = $distinctConversationCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_files_uploaded_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctFilesUploadedCount(
        ?int $distinctFilesUploadedCount
    ): self {
        $self = clone $this;
        $self['distinctFilesUploadedCount'] = $distinctFilesUploadedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_projects_created_count`, for activity recorded while members had Chat and Cowork unified turned on. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withDistinctProjectsCreatedCount(
        int $distinctProjectsCreatedCount
    ): self {
        $self = clone $this;
        $self['distinctProjectsCreatedCount'] = $distinctProjectsCreatedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_projects_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctProjectsUsedCount(
        ?int $distinctProjectsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctProjectsUsedCount'] = $distinctProjectsUsedCount;

        return $self;
    }

    /**
     * Always null: shared-artifact views are not currently measured.
     */
    public function withDistinctSharedArtifactsViewedCount(
        ?int $distinctSharedArtifactsViewedCount
    ): self {
        $self = clone $this;
        $self['distinctSharedArtifactsViewedCount'] = $distinctSharedArtifactsViewedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_skills_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSkillsUsedCount(
        ?int $distinctSkillsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.message_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.shared_conversations_viewed_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withSharedConversationsViewedCount(
        int $sharedConversationsViewedCount
    ): self {
        $self = clone $this;
        $self['sharedConversationsViewedCount'] = $sharedConversationsViewedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.thinking_message_count`, for activity recorded while members had Chat and Cowork unified turned on.
     */
    public function withThinkingMessageCount(int $thinkingMessageCount): self
    {
        $self = clone $this;
        $self['thinkingMessageCount'] = $thinkingMessageCount;

        return $self;
    }
}
