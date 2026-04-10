<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\SkillCreateParams;
use Anthropic\Beta\Skills\SkillDeleteParams;
use Anthropic\Beta\Skills\SkillDeleteResponse;
use Anthropic\Beta\Skills\SkillGetResponse;
use Anthropic\Beta\Skills\SkillListParams;
use Anthropic\Beta\Skills\SkillListResponse;
use Anthropic\Beta\Skills\SkillNewResponse;
use Anthropic\Beta\Skills\SkillRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\SkillsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SkillsRawService implements SkillsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Skill
     *
     * @param array{
     *   displayTitle?: string|null,
     *   files?: list<string|FileParam>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SkillCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SkillNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|SkillCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SkillCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/skills?beta=true',
            headers: Util::array_transform_keys(
                [
                    'Content-Type' => 'multipart/form-data',
                    ...array_intersect_key(
                        $parsed,
                        array_flip(array_keys($header_params))
                    ),
                ],
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'skills-2025-10-02']],
                $options
            ),
            convert: SkillNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get Skill
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|SkillRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SkillGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        array|SkillRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SkillRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/skills/%1$s?beta=true', $skillID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'skills-2025-10-02']],
                $options
            ),
            convert: SkillGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List Skills
     *
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   source?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SkillListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SkillListResponse>>
     *
     * @throws APIException
     */
    public function list(
        array|SkillListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SkillListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page', 'source']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/skills?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'skills-2025-10-02']],
                $options
            ),
            convert: SkillListResponse::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete Skill
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|SkillDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SkillDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        array|SkillDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SkillDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/skills/%1$s?beta=true', $skillID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'skills-2025-10-02']],
                $options
            ),
            convert: SkillDeleteResponse::class,
        );
    }
}
