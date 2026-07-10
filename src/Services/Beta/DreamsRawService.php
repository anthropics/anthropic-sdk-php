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
     * Create a Dream
     *
     * @param array{
     *   inputs: list<BetaDreamInputShape>,
     *   model: ModelShape,
     *   instructions?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
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
        $header_params = ['betas' => 'anthropic-beta'];

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
     * Get a Dream
     *
     * @param string $dreamID Path parameter dream_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
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
                ['betas' => 'anthropic-beta']
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
     * List Dreams
     *
     * @param array{
     *   createdAtGt?: \DateTimeInterface,
     *   createdAtLt?: \DateTimeInterface,
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   statuses?: list<BetaDreamStatus|value-of<BetaDreamStatus>>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
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
                ['betas' => 'anthropic-beta']
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
     * Archive a Dream
     *
     * @param string $dreamID Path parameter dream_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
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
                ['betas' => 'anthropic-beta']
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
     * Cancel a Dream
     *
     * @param string $dreamID Path parameter dream_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
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
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'dreaming-2026-04-21']],
                $options,
            ),
            convert: BetaDream::class,
        );
    }
}
