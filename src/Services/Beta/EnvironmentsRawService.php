<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\BetaCloudConfigParams;
use Anthropic\Beta\Environments\BetaEnvironment;
use Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;
use Anthropic\Beta\Environments\EnvironmentArchiveParams;
use Anthropic\Beta\Environments\EnvironmentCreateParams;
use Anthropic\Beta\Environments\EnvironmentDeleteParams;
use Anthropic\Beta\Environments\EnvironmentListParams;
use Anthropic\Beta\Environments\EnvironmentRetrieveParams;
use Anthropic\Beta\Environments\EnvironmentUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\EnvironmentsRawContract;

/**
 * @phpstan-import-type BetaCloudConfigParamsShape from \Anthropic\Beta\Environments\BetaCloudConfigParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class EnvironmentsRawService implements EnvironmentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new environment with the specified configuration.
     *
     * @param array{
     *   name: string,
     *   config?: BetaCloudConfigParams|BetaCloudConfigParamsShape|null,
     *   description?: string|null,
     *   metadata?: array<string,string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|EnvironmentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function create(
        array|EnvironmentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EnvironmentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/environments?beta=true',
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
            convert: BetaEnvironment::class,
        );
    }

    /**
     * @api
     *
     * Retrieve a specific environment by ID.
     *
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|EnvironmentRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function retrieve(
        string $environmentID,
        array|EnvironmentRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EnvironmentRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/environments/%1$s?beta=true', $environmentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaEnvironment::class,
        );
    }

    /**
     * @api
     *
     * Update an existing environment's configuration.
     *
     * @param string $environmentID Path param
     * @param array{
     *   config?: BetaCloudConfigParams|BetaCloudConfigParamsShape|null,
     *   description?: string|null,
     *   metadata?: array<string,string|null>,
     *   name?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|EnvironmentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function update(
        string $environmentID,
        array|EnvironmentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EnvironmentUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/environments/%1$s?beta=true', $environmentID],
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
            convert: BetaEnvironment::class,
        );
    }

    /**
     * @api
     *
     * List environments with pagination support.
     *
     * @param array{
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|EnvironmentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaEnvironment>>
     *
     * @throws APIException
     */
    public function list(
        array|EnvironmentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EnvironmentListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['includeArchived', 'limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/environments?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['includeArchived' => 'include_archived'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaEnvironment::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete an environment by ID. Returns a confirmation of the deletion.
     *
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|EnvironmentDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironmentDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $environmentID,
        array|EnvironmentDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EnvironmentDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/environments/%1$s?beta=true', $environmentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaEnvironmentDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Archive an environment by ID. Archived environments cannot be used to create new sessions.
     *
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|EnvironmentArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function archive(
        string $environmentID,
        array|EnvironmentArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EnvironmentArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/environments/%1$s/archive?beta=true', $environmentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaEnvironment::class,
        );
    }
}
