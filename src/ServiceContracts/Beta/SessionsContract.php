<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeletedSession;
use Anthropic\Beta\Sessions\BetaManagedAgentsSession;
use Anthropic\Beta\Sessions\SessionListParams\Order;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Sessions\SessionCreateParams\Agent
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Sessions\SessionCreateParams\Resource
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SessionsContract
{
    /**
     * @api
     *
     * @param AgentShape $agent Body param: Agent identifier. Accepts the `agent` ID string, which pins the latest version for the session, or an `agent` object with both id and version specified.
     * @param string $environmentID body param: ID of the `environment` defining the container configuration for this session
     * @param array<string,string> $metadata Body param: Arbitrary key-value metadata attached to the session. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     * @param list<ResourceShape> $resources Body param: Resources (e.g. repositories, files) to mount into the session's container.
     * @param string|null $title body param: Human-readable session title
     * @param list<string> $vaultIDs body param: Vault IDs for stored credentials the agent can use during the session
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string|BetaManagedAgentsAgentParams|array $agent,
        string $environmentID,
        ?array $metadata = null,
        ?array $resources = null,
        ?string $title = null,
        ?array $vaultIDs = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsSession;

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsSession;

    /**
     * @api
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array<string,string|null>|null $metadata Body param: Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve.
     * @param string|null $title body param: Human-readable session title
     * @param list<string> $vaultIDs Body param: Vault IDs (`vlt_*`) to attach to the session. Not yet supported; requests setting this field are rejected. Reserved for future use.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $sessionID,
        ?array $metadata = null,
        ?string $title = null,
        ?array $vaultIDs = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsSession;

    /**
     * @api
     *
     * @param string $agentID query param: Filter sessions created with this agent ID
     * @param int $agentVersion Query param: Filter by agent version. Only applies when agent_id is also set.
     * @param \DateTimeInterface $createdAtGt query param: Return sessions created after this time (exclusive)
     * @param \DateTimeInterface $createdAtGte query param: Return sessions created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLt query param: Return sessions created before this time (exclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return sessions created at or before this time (inclusive)
     * @param bool $includeArchived Query param: When true, includes archived sessions. Default: false (exclude archived).
     * @param int $limit query param: Maximum number of results to return
     * @param Order|value-of<Order> $order Query param: Sort direction for results, ordered by created_at. Defaults to desc (newest first).
     * @param string $page query param: Opaque pagination cursor from a previous response's next_page
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function list(
        ?string $agentID = null,
        ?int $agentVersion = null,
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeletedSession;

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsSession;
}
