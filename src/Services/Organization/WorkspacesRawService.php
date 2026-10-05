<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\Workspaces\DataResidencyCreateConfig;
use Anthropic\Organization\Workspaces\DataResidencyUpdateConfig;
use Anthropic\Organization\Workspaces\Workspace;
use Anthropic\Organization\Workspaces\WorkspaceCreateParams;
use Anthropic\Organization\Workspaces\WorkspaceListParams;
use Anthropic\Organization\Workspaces\WorkspaceUpdateParams;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\WorkspacesRawContract;

/**
 * @phpstan-import-type DataResidencyCreateConfigShape from \Anthropic\Organization\Workspaces\DataResidencyCreateConfig
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type DataResidencyUpdateConfigShape from \Anthropic\Organization\Workspaces\DataResidencyUpdateConfig
 */
final class WorkspacesRawService implements WorkspacesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Workspace
     *
     * @param array{
     *   name: string,
     *   dataResidency?: DataResidencyCreateConfig|DataResidencyCreateConfigShape|null,
     *   displayColor?: string|null,
     *   externalKeyID?: string|null,
     *   tags?: array<string,string>|null,
     * }|WorkspaceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function create(
        array|WorkspaceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/workspaces',
            body: (object) $parsed,
            options: $options,
            convert: Workspace::class,
        );
    }

    /**
     * @api
     *
     * Get Workspace
     *
     * @param string $workspaceID ID of the Workspace
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function retrieve(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/workspaces/%1$s', $workspaceID],
            options: $requestOptions,
            convert: Workspace::class,
        );
    }

    /**
     * @api
     *
     * Update Workspace
     *
     * @param array{
     *   dataResidency?: DataResidencyUpdateConfig|DataResidencyUpdateConfigShape|null,
     *   displayColor?: string,
     *   externalKeyID?: string,
     *   name?: string,
     *   tags?: array<string,string|null>|null,
     * }|WorkspaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function update(
        string $workspaceID,
        array|WorkspaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/workspaces/%1$s', $workspaceID],
            body: (object) $parsed,
            options: $options,
            convert: Workspace::class,
        );
    }

    /**
     * @api
     *
     * List Workspaces
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   includeArchived?: bool,
     *   includeDefault?: bool,
     *   limit?: int,
     * }|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<Workspace>>
     *
     * @throws APIException
     */
    public function list(
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/workspaces',
            query: Util::array_transform_keys(
                $parsed,
                [
                    'afterID' => 'after_id',
                    'beforeID' => 'before_id',
                    'includeArchived' => 'include_archived',
                    'includeDefault' => 'include_default',
                ],
            ),
            options: $options,
            convert: Workspace::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Archive Workspace
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function archive(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/workspaces/%1$s/archive', $workspaceID],
            options: $requestOptions,
            convert: Workspace::class,
        );
    }
}
