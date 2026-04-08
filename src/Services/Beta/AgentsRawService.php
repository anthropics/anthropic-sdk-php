<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Agents\AgentArchiveParams;
use Anthropic\Beta\Agents\AgentCreateParams;
use Anthropic\Beta\Agents\AgentListParams;
use Anthropic\Beta\Agents\AgentRetrieveParams;
use Anthropic\Beta\Agents\AgentUpdateParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
use Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams;
use Anthropic\Beta\AnthropicBeta;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\AgentsRawContract;

/**
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Agents\AgentCreateParams\Model
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\AgentCreateParams\Tool
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Agents\AgentUpdateParams\Model as ModelShape1
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\AgentUpdateParams\Tool as ToolShape1
 * @phpstan-import-type BetaManagedAgentsURLMCPServerParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams
 * @phpstan-import-type BetaManagedAgentsSkillParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsSkillParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class AgentsRawService implements AgentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Agent
     *
     * @param array{
     *   model: ModelShape,
     *   name: string,
     *   description?: string|null,
     *   mcpServers?: list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>,
     *   metadata?: array<string,string>,
     *   skills?: list<BetaManagedAgentsSkillParamsShape>,
     *   system?: string|null,
     *   tools?: list<ToolShape>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|AgentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function create(
        array|AgentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/agents?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsAgent::class,
        );
    }

    /**
     * @api
     *
     * Get Agent
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param array{
     *   version?: int, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|AgentRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function retrieve(
        string $agentID,
        array|AgentRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['version']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/agents/%1$s?beta=true', $agentID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsAgent::class,
        );
    }

    /**
     * @api
     *
     * Update Agent
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param array{
     *   version: int,
     *   description?: string|null,
     *   mcpServers?: list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null,
     *   metadata?: array<string,string|null>|null,
     *   model?: ModelShape1,
     *   name?: string,
     *   skills?: list<BetaManagedAgentsSkillParamsShape>|null,
     *   system?: string|null,
     *   tools?: list<ToolShape1>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|AgentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function update(
        string $agentID,
        array|AgentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/agents/%1$s?beta=true', $agentID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsAgent::class,
        );
    }

    /**
     * @api
     *
     * List Agents
     *
     * @param array{
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|AgentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsAgent>>
     *
     * @throws APIException
     */
    public function list(
        array|AgentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['createdAtGte', 'createdAtLte', 'includeArchived', 'limit', 'page']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/agents?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLte' => 'created_at[lte]',
                    'includeArchived' => 'include_archived',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsAgent::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Archive Agent
     *
     * @param string $agentID Path parameter agent_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|AgentArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function archive(
        string $agentID,
        array|AgentArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/agents/%1$s/archive?beta=true', $agentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsAgent::class,
        );
    }
}
