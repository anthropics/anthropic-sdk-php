<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AnthropicHumanReviewShape from \Anthropic\Beta\Organization\Workspaces\AnthropicHumanReview
 * @phpstan-import-type StorageMemberShape from \Anthropic\Beta\Organization\Workspaces\StorageMember
 * @phpstan-import-type StorageMemberVariants from \Anthropic\Beta\Organization\Workspaces\StorageMember
 *
 * @phpstan-type InferenceDataPrivacyShape = array{
 *   humanReview?: null|AnthropicHumanReview|AnthropicHumanReviewShape,
 *   safeguardsStorage?: StorageMemberShape|null,
 *   transcriptsStorage?: StorageMemberShape|null,
 * }
 */
final class InferenceDataPrivacy implements BaseModel
{
    /** @use SdkModel<InferenceDataPrivacyShape> */
    use SdkModel;

    /**
     * The Workspace's human review setting. Human review is off only while this is `disabled` and Anthropic's approval stands.
     */
    #[Optional('human_review')]
    public ?AnthropicHumanReview $humanReview;

    /**
     * Where the data Anthropic's safeguards systems retain for the Workspace goes. `external` sends it to the External Storage that `external_storage_id` names. `internal` means no External Storage: it goes to Anthropic's storage or, on a cloud provider's platform, to that provider's storage. A recent change may not have taken effect yet.
     *
     * @var StorageMemberVariants|null $safeguardsStorage
     */
    #[Optional('safeguards_storage', union: StorageMember::class)]
    public InternalStorage|ExternalStorageMember|null $safeguardsStorage;

    /**
     * Where copies of the Workspace's transcripts and its cases (Anthropic's safety findings about those transcripts) go. `external` sends them to the External Storage that `external_storage_id` names. `internal` means no External Storage, so no copies are made. A recent change may not have taken effect yet.
     *
     * @var StorageMemberVariants|null $transcriptsStorage
     */
    #[Optional('transcripts_storage', union: StorageMember::class)]
    public InternalStorage|ExternalStorageMember|null $transcriptsStorage;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AnthropicHumanReview|AnthropicHumanReviewShape|null $humanReview
     * @param StorageMemberShape|null $safeguardsStorage
     * @param StorageMemberShape|null $transcriptsStorage
     */
    public static function with(
        AnthropicHumanReview|array|null $humanReview = null,
        InternalStorage|array|ExternalStorageMember|null $safeguardsStorage = null,
        InternalStorage|array|ExternalStorageMember|null $transcriptsStorage = null,
    ): self {
        $self = new self;

        null !== $humanReview && $self['humanReview'] = $humanReview;
        null !== $safeguardsStorage && $self['safeguardsStorage'] = $safeguardsStorage;
        null !== $transcriptsStorage && $self['transcriptsStorage'] = $transcriptsStorage;

        return $self;
    }

    /**
     * The Workspace's human review setting. Human review is off only while this is `disabled` and Anthropic's approval stands.
     *
     * @param AnthropicHumanReview|AnthropicHumanReviewShape $humanReview
     */
    public function withHumanReview(
        AnthropicHumanReview|array $humanReview
    ): self {
        $self = clone $this;
        $self['humanReview'] = $humanReview;

        return $self;
    }

    /**
     * Where the data Anthropic's safeguards systems retain for the Workspace goes. `external` sends it to the External Storage that `external_storage_id` names. `internal` means no External Storage: it goes to Anthropic's storage or, on a cloud provider's platform, to that provider's storage. A recent change may not have taken effect yet.
     *
     * @param StorageMemberShape $safeguardsStorage
     */
    public function withSafeguardsStorage(
        InternalStorage|array|ExternalStorageMember $safeguardsStorage
    ): self {
        $self = clone $this;
        $self['safeguardsStorage'] = $safeguardsStorage;

        return $self;
    }

    /**
     * Where copies of the Workspace's transcripts and its cases (Anthropic's safety findings about those transcripts) go. `external` sends them to the External Storage that `external_storage_id` names. `internal` means no External Storage, so no copies are made. A recent change may not have taken effect yet.
     *
     * @param StorageMemberShape $transcriptsStorage
     */
    public function withTranscriptsStorage(
        InternalStorage|array|ExternalStorageMember $transcriptsStorage
    ): self {
        $self = clone $this;
        $self['transcriptsStorage'] = $transcriptsStorage;

        return $self;
    }
}
