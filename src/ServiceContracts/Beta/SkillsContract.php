<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\BetaDeletedSkill;
use Anthropic\Beta\Skills\BetaSkill;
use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\CMEKContextUnavailableException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\OrganizationOnHoldException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SkillsContract
{
    /**
     * @api
     *
     * @param list<string|FileParam> $files Body param: Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     * @param string|null $displayName Body param: Human-readable, single-line label for the Skill. Maximum 255 characters.
     * Always set: derived from the SKILL.md frontmatter `name` when omitted at
     * creation. Not unique.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional header to specify the beta version(s) you want to use.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws CMEKKeyNetworkBlockedException The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws CMEKContextUnavailableException The workspace's encryption settings could not be read, so the request was refused. Retry in a few minutes.
     * @throws APIException
     */
    public function create(
        array $files,
        ?string $displayName = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaSkill;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional header to specify the beta version(s) you want to use.
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaSkill;

    /**
     * @api
     *
     * @param int $limit Query param: Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     * @param string|null $page Query param: Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     * @param string|null $source Query param: Filter skills by source.
     *
     * If provided, only skills from the specified source will be returned:
     * * `"custom"`: only return user-created skills
     * * `"anthropic"`: only return Anthropic-created skills
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional header to specify the beta version(s) you want to use.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaSkill>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?string $source = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional header to specify the beta version(s) you want to use.
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function delete(
        string $skillID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDeletedSkill;
}
