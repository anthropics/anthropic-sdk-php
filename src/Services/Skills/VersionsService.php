<?php

declare(strict_types=1);

namespace Anthropic\Services\Skills;

use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\Client;
use Anthropic\CMEKContextUnavailableException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\OrganizationOnHoldException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Skills\VersionsContract;
use Anthropic\Skills\Versions\DeletedSkillVersion;
use Anthropic\Skills\Versions\SkillVersion;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class VersionsService implements VersionsContract
{
    /**
     * @api
     */
    public VersionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new VersionsRawService($client);
    }

    /**
     * @api
     *
     * Create Skill Version
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|FileParam> $files Body param: Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
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
        string $skillID,
        array $files,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): SkillVersion {
        $params = Util::removeNulls(
            ['files' => $files, 'workspaceID' => $workspaceID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($skillID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get Skill Version
     *
     * @param string $version Path param: Identifies the skill version: a version ID, or the literal `latest` for the skill's most recent version.
     *
     * Requests carrying the `skills-2025-10-02` beta header address versions by their Unix epoch timestamp instead (e.g., "1759178010641129").
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function retrieve(
        string $version,
        string $skillID,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): SkillVersion {
        $params = Util::removeNulls(
            ['skillID' => $skillID, 'workspaceID' => $workspaceID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($version, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Skill Versions
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param int|null $limit Query param: Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     * @param string|null $page Query param: Optionally set to the `next_page` token from the previous response.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<SkillVersion>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function list(
        string $skillID,
        ?int $limit = null,
        ?string $page = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'workspaceID' => $workspaceID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($skillID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete Skill Version
     *
     * @param string $version Path param: Identifies the skill version by its version ID.
     *
     * Requests carrying the `skills-2025-10-02` beta header address versions by their Unix epoch timestamp instead (e.g., "1759178010641129").
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function delete(
        string $version,
        string $skillID,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedSkillVersion {
        $params = Util::removeNulls(
            ['skillID' => $skillID, 'workspaceID' => $workspaceID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($version, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
