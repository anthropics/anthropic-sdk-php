<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\SkillDeleteResponse;
use Anthropic\Beta\Skills\SkillGetResponse;
use Anthropic\Beta\Skills\SkillListResponse;
use Anthropic\Beta\Skills\SkillNewResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface SkillsContract
{
    /**
     * @api
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
    ): SkillNewResponse;

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
    ): SkillNewResponse;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): SkillGetResponse;

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
    ): SkillGetResponse;

    /**
     * @api
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
    ): PageCursor;

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
    ): PageCursor;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): SkillDeleteResponse;

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
    ): SkillDeleteResponse;
}
