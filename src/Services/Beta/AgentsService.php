<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
use Anthropic\Beta\Agents\BetaManagedAgentsModel;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams;
use Anthropic\Beta\AnthropicBeta;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\AgentsContract;
use Anthropic\Services\Beta\Agents\VersionsService;

/**
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Agents\AgentCreateParams\Model
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\AgentCreateParams\Tool
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Agents\AgentUpdateParams\Model as ModelShape1
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\AgentUpdateParams\Tool as ToolShape1
 * @phpstan-import-type BetaManagedAgentsURLMCPServerParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams
 * @phpstan-import-type BetaManagedAgentsSkillParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class AgentsService implements AgentsContract
{
    /**
     * @api
     */
    public AgentsRawService $raw;

    /**
     * @api
     */
    public VersionsService $versions;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AgentsRawService($client);
        $this->versions = new VersionsService($client);
    }

    /**
     * @api
     *
     * Create Agent
     *
     * @param ModelShape $model Body param: Model identifier. Accepts the [model string](https://platform.claude.com/docs/en/about-claude/models/overview#latest-models-comparison), e.g. `claude-opus-4-6`, or a `model_config` object for additional configuration control
     * @param string $name Body param: Human-readable name for the agent. 1-256 characters.
     * @param string|null $description Body param: Description of what the agent does. Up to 2048 characters.
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape> $mcpServers Body param: MCP servers this agent connects to. Maximum 20. Names must be unique within the array.
     * @param array<string,string> $metadata Body param: Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     * @param list<BetaManagedAgentsSkillParamsShape> $skills Body param: Skills available to the agent. Maximum 20.
     * @param string|null $system Body param: System prompt for the agent. Up to 100,000 characters.
     * @param list<ToolShape> $tools Body param: Tool configurations available to the agent. Maximum of 128 tools across all toolsets allowed.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        BetaManagedAgentsModel|BetaManagedAgentsModelConfigParams|array|string $model,
        string $name,
        ?string $description = null,
        ?array $mcpServers = null,
        ?array $metadata = null,
        ?array $skills = null,
        ?string $system = null,
        ?array $tools = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsAgent {
        $params = Util::removeNulls(
            [
                'model' => $model,
                'name' => $name,
                'description' => $description,
                'mcpServers' => $mcpServers,
                'metadata' => $metadata,
                'skills' => $skills,
                'system' => $system,
                'tools' => $tools,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get Agent
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param int $version Query param: Agent version. Omit for the most recent version. Must be at least 1 if specified.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $agentID,
        ?int $version = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsAgent {
        $params = Util::removeNulls(['version' => $version, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($agentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update Agent
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param int $version Body param: The agent's current version, used to prevent concurrent overwrites. Obtain this value from a create or retrieve response. The request fails if this does not match the server's current version.
     * @param string|null $description Body param: Description. Up to 2048 characters. Omit to preserve; send empty string or null to clear.
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null $mcpServers Body param: MCP servers. Full replacement. Omit to preserve; send empty array or null to clear. Names must be unique. Maximum 20.
     * @param array<string,string|null>|null $metadata Body param: Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve. The stored bag is limited to 16 keys (up to 64 chars each) with values up to 512 chars.
     * @param ModelShape1 $model Body param: Model identifier. Accepts the [model string](https://platform.claude.com/docs/en/about-claude/models/overview#latest-models-comparison), e.g. `claude-opus-4-6`, or a `model_config` object for additional configuration control. Omit to preserve. Cannot be cleared.
     * @param string $name Body param: Human-readable name. 1-256 characters. Omit to preserve. Cannot be cleared.
     * @param list<BetaManagedAgentsSkillParamsShape>|null $skills Body param: Skills. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 20.
     * @param string|null $system Body param: System prompt. Up to 100,000 characters. Omit to preserve; send empty string or null to clear.
     * @param list<ToolShape1>|null $tools Body param: Tool configurations available to the agent. Full replacement. Omit to preserve; send empty array or null to clear. Maximum of 128 tools across all toolsets allowed.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $agentID,
        int $version,
        ?string $description = null,
        ?array $mcpServers = null,
        ?array $metadata = null,
        BetaManagedAgentsModel|BetaManagedAgentsModelConfigParams|array|string|null $model = null,
        ?string $name = null,
        ?array $skills = null,
        ?string $system = null,
        ?array $tools = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsAgent {
        $params = Util::removeNulls(
            [
                'version' => $version,
                'description' => $description,
                'mcpServers' => $mcpServers,
                'metadata' => $metadata,
                'model' => $model,
                'name' => $name,
                'skills' => $skills,
                'system' => $system,
                'tools' => $tools,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($agentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Agents
     *
     * @param \DateTimeInterface $createdAtGte query param: Return agents created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return agents created at or before this time (inclusive)
     * @param bool $includeArchived Query param: Include archived agents in results. Defaults to false.
     * @param int $limit Query param: Maximum results per page. Default 20, maximum 100.
     * @param string $page query param: Opaque pagination cursor from a previous response
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function list(
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'createdAtGte' => $createdAtGte,
                'createdAtLte' => $createdAtLte,
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive Agent
     *
     * @param string $agentID Path parameter agent_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $agentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsAgent {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($agentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
