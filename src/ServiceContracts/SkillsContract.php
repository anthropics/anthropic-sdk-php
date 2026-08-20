<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\Skills\DeletedSkill;
use Anthropic\Skills\Skill;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SkillsContract
{
    /**
     * @api
     *
     * @param list<string|FileParam> $files Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     * @param string|null $displayName Human-readable, single-line label for the Skill. Maximum 255 characters.
     * Always set: derived from the SKILL.md frontmatter `name` when omitted at
     * creation. Not unique.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $files,
        ?string $displayName = null,
        RequestOptions|array|null $requestOptions = null,
    ): Skill;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        RequestOptions|array|null $requestOptions = null
    ): Skill;

    /**
     * @api
     *
     * @param int $limit Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     * @param string|null $page Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     * @param string|null $source Filter skills by source.
     *
     * If provided, only skills from the specified source will be returned:
     * * `"custom"`: only return user-created skills
     * * `"anthropic"`: only return Anthropic-created skills
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<Skill>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?string $source = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        RequestOptions|array|null $requestOptions = null
    ): DeletedSkill;
}
