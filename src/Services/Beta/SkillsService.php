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
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\SkillsContract;
use Anthropic\Services\Beta\Skills\VersionsService;

use const Anthropic\Core\OMIT as omit;

final class SkillsService implements SkillsContract
{
    /**
     * @@api
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
     * @param string|null $displayTitle Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     * @param list<string>|null $files Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function create(
        $displayTitle = omit,
        $files = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): SkillNewResponse {
        $params = [
            'displayTitle' => $displayTitle, 'files' => $files, 'betas' => $betas,
        ];

        return $this->createRaw($params, $requestOptions);
    }

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @throws APIException
     */
    public function createRaw(
        array $params,
        ?RequestOptions $requestOptions = null
    ): SkillNewResponse {
        [$parsed, $options] = SkillCreateParams::parseRequest(
            $params,
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line;
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
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): SkillGetResponse {
        $params = ['betas' => $betas];

        return $this->retrieveRaw($skillID, $params, $requestOptions);
    }

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @throws APIException
     */
    public function retrieveRaw(
        string $skillID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): SkillGetResponse {
        [$parsed, $options] = SkillRetrieveParams::parseRequest(
            $params,
            $requestOptions
        );

        // @phpstan-ignore-next-line;
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
     * @param int $limit Number of results to return per page.
     *
     * Maximum value is 100. Defaults to 20.
     * @param string|null $page Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     * @param string|null $source Filter skills by source.
     *
     * If provided, only skills from the specified source will be returned:
     * * `"custom"`: only return user-created skills
     * * `"anthropic"`: only return Anthropic-created skills
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return PageCursor<SkillListResponse>
     *
     * @throws APIException
     */
    public function list(
        $limit = omit,
        $page = omit,
        $source = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): PageCursor {
        $params = [
            'limit' => $limit, 'page' => $page, 'source' => $source, 'betas' => $betas,
        ];

        return $this->listRaw($params, $requestOptions);
    }

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return PageCursor<SkillListResponse>
     *
     * @throws APIException
     */
    public function listRaw(
        array $params,
        ?RequestOptions $requestOptions = null
    ): PageCursor {
        [$parsed, $options] = SkillListParams::parseRequest(
            $params,
            $requestOptions
        );
        $query_params = array_flip(['limit', 'page', 'source']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line;
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
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): SkillDeleteResponse {
        $params = ['betas' => $betas];

        return $this->deleteRaw($skillID, $params, $requestOptions);
    }

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @throws APIException
     */
    public function deleteRaw(
        string $skillID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): SkillDeleteResponse {
        [$parsed, $options] = SkillDeleteParams::parseRequest(
            $params,
            $requestOptions
        );

        // @phpstan-ignore-next-line;
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
