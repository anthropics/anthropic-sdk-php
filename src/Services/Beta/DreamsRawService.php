<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Dreams\BetaDream;
use Anthropic\Beta\Dreams\BetaDreamStatus;
use Anthropic\Beta\Dreams\DreamArchiveParams;
use Anthropic\Beta\Dreams\DreamCancelParams;
use Anthropic\Beta\Dreams\DreamCreateParams;
use Anthropic\Beta\Dreams\DreamListParams;
use Anthropic\Beta\Dreams\DreamRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\DreamsRawContract;

/**
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 * @phpstan-import-type BetaOutputBehaviorShape from \Anthropic\Beta\Dreams\BetaOutputBehavior
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class DreamsRawService implements DreamsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Start an asynchronous job that uses past sessions to produce a reorganized version of a memory store and get back the dream to poll for the result.
     *
     * By default the dream writes its result to a new memory store and doesn't change the input memory store. The response has `status` set to `pending` and an empty `outputs` array. Poll the dream until `status` is `completed`, `failed`, or `canceled`.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#create-a-dream) to learn more about creating dreams.
     *
     * @param array{
     *   inputs: list<BetaDreamInputShape>,
     *   model: ModelShape,
     *   instructions?: string|null,
     *   outputBehavior?: BetaOutputBehaviorShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|DreamCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function create(
        array|DreamCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DreamCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/dreams?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'dreaming-2026-04-21']],
                $options,
            ),
            convert: BetaDream::class,
        );
    }

    /**
     * @api
     *
     * Get a dream by ID to check its status, output memory store, and token usage.
     *
     * Archived dreams are returned too.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#track-progress) for how to poll a dream and what each status means.
     *
     * @param string $dreamID The ID of the dream to get (`drm_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|DreamRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function retrieve(
        string $dreamID,
        array|DreamRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DreamRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/dreams/%1$s?beta=true', $dreamID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'dreaming-2026-04-21']],
                $options,
            ),
            convert: BetaDream::class,
        );
    }

    /**
     * @api
     *
     * List the dreams in the workspace, newest first.
     *
     * Archived dreams are left out unless `include_archived` is `true`.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#list-dreams) for how to page through dreams.
     *
     * @param array{
     *   createdAtGt?: \DateTimeInterface,
     *   createdAtLt?: \DateTimeInterface,
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   statuses?: list<BetaDreamStatus|value-of<BetaDreamStatus>>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|DreamListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaDream>>
     *
     * @throws APIException
     */
    public function list(
        array|DreamListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DreamListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'createdAtGt',
                'createdAtLt',
                'includeArchived',
                'limit',
                'page',
                'statuses',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/dreams?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'createdAtGt' => 'created_at[gt]',
                    'createdAtLt' => 'created_at[lt]',
                    'includeArchived' => 'include_archived',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'dreaming-2026-04-21']],
                $options,
            ),
            convert: BetaDream::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Hide a `completed`, `failed`, or `canceled` dream from the default list of dreams.
     *
     * Archiving a `pending` or `running` dream returns a 400 error, so cancel it first. Archiving an archived dream returns it unchanged. An archived dream can still be fetched by ID. Archiving can't be undone.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#archive-a-dream) to learn more about archiving dreams.
     *
     * @param string $dreamID The ID of the dream to archive (`drm_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|DreamArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function archive(
        string $dreamID,
        array|DreamArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DreamArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/dreams/%1$s/archive?beta=true', $dreamID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'dreaming-2026-04-21']],
                $options,
            ),
            convert: BetaDream::class,
        );
    }

    /**
     * @api
     *
     * Stop a `pending` or `running` dream.
     *
     * The response shows `status` as `canceled`, unless the dream reached `completed` or `failed` first. `usage` can keep changing after the response. Canceling a `canceled` dream returns it unchanged. Canceling a `completed` or `failed` dream returns a 400 error.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#cancel-a-dream) to learn more about canceling dreams.
     *
     * @param string $dreamID The ID of the dream to cancel (`drm_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|DreamCancelParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function cancel(
        string $dreamID,
        array|DreamCancelParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DreamCancelParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/dreams/%1$s/cancel?beta=true', $dreamID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'dreaming-2026-04-21']],
                $options,
            ),
            convert: BetaDream::class,
        );
    }
}
