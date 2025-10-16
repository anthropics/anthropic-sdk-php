<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\Versions\VersionDeleteResponse;
use Anthropic\Beta\Skills\Versions\VersionGetResponse;
use Anthropic\Beta\Skills\Versions\VersionListResponse;
use Anthropic\Beta\Skills\Versions\VersionNewResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface VersionsContract
{
    /**
     * @api
     *
     * @param list<string>|null $files Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function create(
        string $skillID,
        $files = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): VersionNewResponse;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @throws APIException
     */
    public function createRaw(
        string $skillID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): VersionNewResponse;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        $skillID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): VersionGetResponse;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @throws APIException
     */
    public function retrieveRaw(
        string $version,
        array $params,
        ?RequestOptions $requestOptions = null
    ): VersionGetResponse;

    /**
     * @api
     *
     * @param int|null $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page optionally set to the `next_page` token from the previous response
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return PageCursor<VersionListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $skillID,
        $limit = omit,
        $page = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return PageCursor<VersionListResponse>
     *
     * @throws APIException
     */
    public function listRaw(
        string $skillID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): PageCursor;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function delete(
        string $version,
        $skillID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): VersionDeleteResponse;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @throws APIException
     */
    public function deleteRaw(
        string $version,
        array $params,
        ?RequestOptions $requestOptions = null
    ): VersionDeleteResponse;
}
