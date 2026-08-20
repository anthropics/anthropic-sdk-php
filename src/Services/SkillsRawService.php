<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\SkillsRawContract;
use Anthropic\Skills\DeletedSkill;
use Anthropic\Skills\Skill;
use Anthropic\Skills\SkillCreateParams;
use Anthropic\Skills\SkillListParams;

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
     *   files: list<string|FileParam>, displayName?: string|null
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/skills',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Skill>
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/skills/%1$s', $skillID],
            options: $requestOptions,
            convert: Skill::class,
        );
    }

    /**
     * @api
     *
     * List Skills
     *
     * @param array{
     *   limit?: int, page?: string|null, source?: string|null
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/skills',
            query: $parsed,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedSkill>
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/skills/%1$s', $skillID],
            options: $requestOptions,
            convert: DeletedSkill::class,
        );
    }
}
