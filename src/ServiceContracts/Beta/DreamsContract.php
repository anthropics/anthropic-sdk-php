<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Dreams\BetaDream;
use Anthropic\Beta\Dreams\BetaDreamModelConfigParam;
use Anthropic\Beta\Dreams\BetaDreamStatus;
use Anthropic\Beta\Dreams\BetaOutputBehaviorCreateNew;
use Anthropic\Beta\Dreams\BetaOutputBehaviorUpdateExisting;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 * @phpstan-import-type BetaOutputBehaviorShape from \Anthropic\Beta\Dreams\BetaOutputBehavior
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DreamsContract
{
    /**
     * @api
     *
     * @param list<BetaDreamInputShape> $inputs body param: The memory store and sessions for the dream to read, as exactly one `memory_store` entry and exactly one `sessions` entry
     * @param ModelShape $model Body param: The model that runs a dream, given as a model ID or as an object with `id` and `speed`.
     *
     * In the object form, `speed` can only be `standard`.
     *
     * The [limits table in the Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#limits) lists the supported models.
     * @param string|null $instructions Body param: Guidance that steers how the dream reads the sessions and organizes the output memory store, from 1 to 4,096 characters.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#steer-with-instructions) for what kinds of instructions work well.
     * @param BetaOutputBehaviorShape $outputBehavior Body param: Which memory store a dream writes its result to. Defaults to `create_new` when left out of a create request.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $inputs,
        string|BetaDreamModelConfigParam|array $model,
        ?string $instructions = null,
        BetaOutputBehaviorCreateNew|array|BetaOutputBehaviorUpdateExisting|null $outputBehavior = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream;

    /**
     * @api
     *
     * @param string $dreamID The ID of the dream to get (`drm_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $dreamID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream;

    /**
     * @api
     *
     * @param \DateTimeInterface $createdAtGt Query param: Return dreams with `created_at` strictly after this timestamp (exclusive lower bound, RFC 3339). Unset applies no lower bound.
     * @param \DateTimeInterface $createdAtLt Query param: Return dreams with `created_at` strictly before this timestamp (exclusive upper bound, RFC 3339). Unset applies no upper bound.
     * @param bool $includeArchived Query param: Whether to include archived dreams. Defaults to `false`.
     * @param int $limit Query param: The maximum number of dreams to return, from 1 to 100. Defaults to 20.
     * @param string $page Query param: The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     * @param list<BetaDreamStatus|value-of<BetaDreamStatus>> $statuses Query param: Filter by lifecycle status. Repeat the parameter to match any of multiple statuses. Empty applies no status filter.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaDream>
     *
     * @throws APIException
     */
    public function list(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $statuses = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $dreamID The ID of the dream to archive (`drm_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $dreamID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream;

    /**
     * @api
     *
     * @param string $dreamID The ID of the dream to cancel (`drm_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $dreamID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream;
}
