<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeletedSession;
use Anthropic\Beta\Sessions\BetaManagedAgentsSession;
use Anthropic\Beta\Sessions\SessionArchiveParams;
use Anthropic\Beta\Sessions\SessionCreateParams;
use Anthropic\Beta\Sessions\SessionDeleteParams;
use Anthropic\Beta\Sessions\SessionListParams;
use Anthropic\Beta\Sessions\SessionListParams\Order;
use Anthropic\Beta\Sessions\SessionRetrieveParams;
use Anthropic\Beta\Sessions\SessionUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\SessionsRawContract;

/**
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Sessions\SessionCreateParams\Agent
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Sessions\SessionCreateParams\Resource
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SessionsRawService implements SessionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Session
     *
     * @param array{
     *   agent: AgentShape,
     *   environmentID: string,
     *   metadata?: array<string,string>,
     *   resources?: list<ResourceShape>,
     *   title?: string|null,
     *   vaultIDs?: list<string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SessionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function create(
        array|SessionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SessionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/sessions?beta=true',
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
            convert: BetaManagedAgentsSession::class,
        );
    }

    /**
     * @api
     *
     * Get Session
     *
     * @param string $sessionID Path parameter session_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|SessionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function retrieve(
        string $sessionID,
        array|SessionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SessionRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sessions/%1$s?beta=true', $sessionID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsSession::class,
        );
    }

    /**
     * @api
     *
     * Update Session
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array{
     *   metadata?: array<string,string|null>|null,
     *   title?: string|null,
     *   vaultIDs?: list<string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SessionUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function update(
        string $sessionID,
        array|SessionUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SessionUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/sessions/%1$s?beta=true', $sessionID],
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
            convert: BetaManagedAgentsSession::class,
        );
    }

    /**
     * @api
     *
     * List Sessions
     *
     * @param array{
     *   agentID?: string,
     *   agentVersion?: int,
     *   createdAtGt?: \DateTimeInterface,
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLt?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   includeArchived?: bool,
     *   limit?: int,
     *   order?: Order|value-of<Order>,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SessionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsSession>>
     *
     * @throws APIException
     */
    public function list(
        array|SessionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SessionListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'agentID',
                'agentVersion',
                'createdAtGt',
                'createdAtGte',
                'createdAtLt',
                'createdAtLte',
                'includeArchived',
                'limit',
                'order',
                'page',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/sessions?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'agentID' => 'agent_id',
                    'agentVersion' => 'agent_version',
                    'createdAtGt' => 'created_at[gt]',
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLt' => 'created_at[lt]',
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
            convert: BetaManagedAgentsSession::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete Session
     *
     * @param string $sessionID Path parameter session_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|SessionDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeletedSession>
     *
     * @throws APIException
     */
    public function delete(
        string $sessionID,
        array|SessionDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SessionDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/sessions/%1$s?beta=true', $sessionID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeletedSession::class,
        );
    }

    /**
     * @api
     *
     * Archive Session
     *
     * @param string $sessionID Path parameter session_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|SessionArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function archive(
        string $sessionID,
        array|SessionArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SessionArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/sessions/%1$s/archive?beta=true', $sessionID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsSession::class,
        );
    }
}
