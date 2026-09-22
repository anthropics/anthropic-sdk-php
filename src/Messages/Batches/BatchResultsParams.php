<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Streams the results of a Message Batch as a `.jsonl` file.
 *
 * Each line in the file is a JSON object containing the result of a single request in the Message Batch. Results are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
 *
 * Learn more about the Message Batches API in our [user guide](https://platform.claude.com/docs/en/build-with-claude/batch-processing)
 *
 * @see Anthropic\Services\Messages\BatchesService::resultsStream()
 *
 * @phpstan-type BatchResultsParamsShape = array{workspaceID?: string|null}
 */
final class BatchResultsParams implements BaseModel
{
    /** @use SdkModel<BatchResultsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $workspaceID = null): self
    {
        $self = new self;

        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
