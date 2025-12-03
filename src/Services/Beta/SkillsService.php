<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Skills\SkillCreateParams;
use Anthropic\Beta\Skills\SkillDeleteParams;
use Anthropic\Beta\Skills\SkillDeleteResponse;
use Anthropic\Beta\Skills\SkillGetResponse;
use Anthropic\Beta\Skills\SkillListParams;
use Anthropic\Beta\Skills\SkillListResponse;
use Anthropic\Beta\Skills\SkillNewResponse;
use Anthropic\Beta\Skills\SkillRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\SkillsContract;
use Anthropic\Services\Beta\Skills\VersionsService;

final class SkillsService implements SkillsContract
{
    /**
     * @api
     */
    public VersionsService $versions;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->versions = new VersionsService($client);
    }

    /**
     * @api
     *
     * Create Skill
     *
     * @param array{
     *   display_title?: string|null, files?: list<string>|null, betas?: list<string>
     * }|SkillCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        array|SkillCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): SkillNewResponse {
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
                    ...array_intersect_key($parsed, array_keys($header_params)),
                ],
                $header_params,
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
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
     * @param array{betas?: list<string>}|SkillRetrieveParams $params
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        array|SkillRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): SkillGetResponse {
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
     *   limit?: int, page?: string|null, source?: string|null, betas?: list<string>
     * }|SkillListParams $params
     *
     * @return PageCursor<SkillListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|SkillListParams $params,
        ?RequestOptions $requestOptions = null
    ): PageCursor {
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
     * @param array{betas?: list<string>}|SkillDeleteParams $params
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        array|SkillDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): SkillDeleteResponse {
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
