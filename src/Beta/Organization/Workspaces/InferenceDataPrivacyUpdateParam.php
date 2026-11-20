<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Changes to where the Workspace's retained inference data and transcript
 * copies go, and to whether Anthropic's human review applies. An omitted member
 * is unchanged; a member cannot be null.
 *
 * @phpstan-import-type AnthropicHumanReviewParamShape from \Anthropic\Beta\Organization\Workspaces\AnthropicHumanReviewParam
 * @phpstan-import-type StorageMemberParamShape from \Anthropic\Beta\Organization\Workspaces\StorageMemberParam
 * @phpstan-import-type StorageMemberParamVariants from \Anthropic\Beta\Organization\Workspaces\StorageMemberParam
 *
 * @phpstan-type InferenceDataPrivacyUpdateParamShape = array{
 *   humanReview?: null|AnthropicHumanReviewParam|AnthropicHumanReviewParamShape,
 *   safeguardsStorage?: StorageMemberParamShape|null,
 *   transcriptsStorage?: StorageMemberParamShape|null,
 * }
 */
final class InferenceDataPrivacyUpdateParam implements BaseModel
{
    /** @use SdkModel<InferenceDataPrivacyUpdateParamShape> */
    use SdkModel;

    /**
     * Whether Anthropic's human review applies to the Workspace from now on. `disabled` needs Anthropic's approval. When omitted, unchanged. Cannot be null.
     */
    #[Optional('human_review')]
    public ?AnthropicHumanReviewParam $humanReview;

    /**
     * Where the data Anthropic's safeguards systems retain for the Workspace goes once the change takes effect. `external` sends it to the External Storage that `external_storage_id` names. `internal` means no External Storage: it goes to Anthropic's storage or, on a cloud provider's platform, to that provider's storage. When omitted, unchanged. Cannot be null.
     *
     * @var StorageMemberParamVariants|null $safeguardsStorage
     */
    #[Optional('safeguards_storage', union: StorageMemberParam::class)]
    public InternalStorageParam|ExternalStorageMemberParam|null $safeguardsStorage;

    /**
     * Where copies of the Workspace's transcripts and its cases (Anthropic's safety findings about those transcripts) go once the change takes effect. `external` sends them to the External Storage that `external_storage_id` names. `internal` means no External Storage, so no more copies are made. When omitted, unchanged. Cannot be null.
     *
     * @var StorageMemberParamVariants|null $transcriptsStorage
     */
    #[Optional('transcripts_storage', union: StorageMemberParam::class)]
    public InternalStorageParam|ExternalStorageMemberParam|null $transcriptsStorage;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AnthropicHumanReviewParam|AnthropicHumanReviewParamShape|null $humanReview
     * @param StorageMemberParamShape|null $safeguardsStorage
     * @param StorageMemberParamShape|null $transcriptsStorage
     */
    public static function with(
        AnthropicHumanReviewParam|array|null $humanReview = null,
        InternalStorageParam|array|ExternalStorageMemberParam|null $safeguardsStorage = null,
        InternalStorageParam|array|ExternalStorageMemberParam|null $transcriptsStorage = null,
    ): self {
        $self = new self;

        null !== $humanReview && $self['humanReview'] = $humanReview;
        null !== $safeguardsStorage && $self['safeguardsStorage'] = $safeguardsStorage;
        null !== $transcriptsStorage && $self['transcriptsStorage'] = $transcriptsStorage;

        return $self;
    }

    /**
     * Whether Anthropic's human review applies to the Workspace from now on. `disabled` needs Anthropic's approval. When omitted, unchanged. Cannot be null.
     *
     * @param AnthropicHumanReviewParam|AnthropicHumanReviewParamShape $humanReview
     */
    public function withHumanReview(
        AnthropicHumanReviewParam|array $humanReview
    ): self {
        $self = clone $this;
        $self['humanReview'] = $humanReview;

        return $self;
    }

    /**
     * Where the data Anthropic's safeguards systems retain for the Workspace goes once the change takes effect. `external` sends it to the External Storage that `external_storage_id` names. `internal` means no External Storage: it goes to Anthropic's storage or, on a cloud provider's platform, to that provider's storage. When omitted, unchanged. Cannot be null.
     *
     * @param StorageMemberParamShape $safeguardsStorage
     */
    public function withSafeguardsStorage(
        InternalStorageParam|array|ExternalStorageMemberParam $safeguardsStorage
    ): self {
        $self = clone $this;
        $self['safeguardsStorage'] = $safeguardsStorage;

        return $self;
    }

    /**
     * Where copies of the Workspace's transcripts and its cases (Anthropic's safety findings about those transcripts) go once the change takes effect. `external` sends them to the External Storage that `external_storage_id` names. `internal` means no External Storage, so no more copies are made. When omitted, unchanged. Cannot be null.
     *
     * @param StorageMemberParamShape $transcriptsStorage
     */
    public function withTranscriptsStorage(
        InternalStorageParam|array|ExternalStorageMemberParam $transcriptsStorage
    ): self {
        $self = clone $this;
        $self['transcriptsStorage'] = $transcriptsStorage;

        return $self;
    }
}
