<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\SkillsRawContract;
use Anthropic\Skills\DeletedSkill;
use Anthropic\Skills\Skill;
use Anthropic\Skills\SkillCreateParams;
use Anthropic\Skills\SkillDeleteParams;
use Anthropic\Skills\SkillListParams;
use Anthropic\Skills\SkillRetrieveParams;

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
     *   files: list<string|FileParam>, displayName?: string|null, workspaceID?: string
     * }|SkillCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Skill>
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
        $header_params = ['workspaceID' => 'anthropic-workspace-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/skills',
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
            options: $options,
            convert: Skill::class,
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
     * @param array{workspaceID?: string}|SkillRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Skill>
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
            path: ['v1/skills/%1$s', $skillID],
            headers: Util::array_transform_keys(
                $parsed,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options,
            convert: Skill::class,
        );
    }

    /**
     * @api
     *
     * List Skills
     *
     * @param array{
     *   limit?: int, page?: string|null, source?: string|null, workspaceID?: string
     * }|SkillListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<Skill>>
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
            path: 'v1/skills',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options,
            convert: Skill::class,
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
     * @param array{workspaceID?: string}|SkillDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedSkill>
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
            path: ['v1/skills/%1$s', $skillID],
            headers: Util::array_transform_keys(
                $parsed,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options,
            convert: DeletedSkill::class,
        );
    }
}
