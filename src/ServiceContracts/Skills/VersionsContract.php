<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Skills;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\Skills\Versions\DeletedSkillVersion;
use Anthropic\Skills\Versions\SkillVersion;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface VersionsContract
{
    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|FileParam> $files Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $skillID,
        array $files,
        RequestOptions|array|null $requestOptions = null,
    ): SkillVersion;

    /**
     * @api
     *
     * @param string $version Identifies the skill version: a version ID, or — where the endpoint accepts it — the literal `latest` for the skill's most recent version.
     *
     * Requests carrying the `skills-2025-10-02` beta header address versions by their Unix epoch timestamp instead (e.g., "1759178010641129").
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        string $skillID,
        RequestOptions|array|null $requestOptions = null,
    ): SkillVersion;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param int|null $limit Number of results to return per page.
     *
     * Ranges from `1` to `1000`. Defaults to `20`.
     * @param string|null $page optionally set to the `next_page` token from the previous response
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<SkillVersion>
     *
     * @throws APIException
     */
    public function list(
        string $skillID,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $version Identifies the skill version: a version ID, or — where the endpoint accepts it — the literal `latest` for the skill's most recent version.
     *
     * Requests carrying the `skills-2025-10-02` beta header address versions by their Unix epoch timestamp instead (e.g., "1759178010641129").
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $version,
        string $skillID,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedSkillVersion;
}
