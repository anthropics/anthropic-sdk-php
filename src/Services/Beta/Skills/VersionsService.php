<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\Versions\VersionCreateParams;
use Anthropic\Beta\Skills\Versions\VersionDeleteParams;
use Anthropic\Beta\Skills\Versions\VersionDeleteResponse;
use Anthropic\Beta\Skills\Versions\VersionGetResponse;
use Anthropic\Beta\Skills\Versions\VersionListParams;
use Anthropic\Beta\Skills\Versions\VersionListResponse;
use Anthropic\Beta\Skills\Versions\VersionNewResponse;
use Anthropic\Beta\Skills\Versions\VersionRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Skills\VersionsContract;

use const Anthropic\Core\OMIT as omit;

final class VersionsService implements VersionsContract
{
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Skill Version
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
    ): VersionNewResponse {
        $params = ['files' => $files, 'betas' => $betas];

        return $this->createRaw($skillID, $params, $requestOptions);
    }

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
    ): VersionNewResponse {
        [$parsed, $options] = VersionCreateParams::parseRequest(
            $params,
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'post',
            path: ['v1/skills/%1$s/versions?beta=true', $skillID],
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
            convert: VersionNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get Skill Version
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
    ): VersionGetResponse {
        $params = ['skillID' => $skillID, 'betas' => $betas];

        return $this->retrieveRaw($version, $params, $requestOptions);
    }

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
    ): VersionGetResponse {
        [$parsed, $options] = VersionRetrieveParams::parseRequest(
            $params,
            $requestOptions
        );
        $skillID = $parsed['skillID'];
        unset($parsed['skillID']);

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: ['v1/skills/%1$s/versions/%2$s?beta=true', $skillID, $version],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'skills-2025-10-02']],
                $options
            ),
            convert: VersionGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List Skill Versions
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
    ): PageCursor {
        $params = ['limit' => $limit, 'page' => $page, 'betas' => $betas];

        return $this->listRaw($skillID, $params, $requestOptions);
    }

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
    ): PageCursor {
        [$parsed, $options] = VersionListParams::parseRequest(
            $params,
            $requestOptions
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: ['v1/skills/%1$s/versions?beta=true', $skillID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'skills-2025-10-02']],
                $options
            ),
            convert: VersionListResponse::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete Skill Version
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
    ): VersionDeleteResponse {
        $params = ['skillID' => $skillID, 'betas' => $betas];

        return $this->deleteRaw($version, $params, $requestOptions);
    }

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
    ): VersionDeleteResponse {
        [$parsed, $options] = VersionDeleteParams::parseRequest(
            $params,
            $requestOptions
        );
        $skillID = $parsed['skillID'];
        unset($parsed['skillID']);

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'delete',
            path: ['v1/skills/%1$s/versions/%2$s?beta=true', $skillID, $version],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'skills-2025-10-02']],
                $options
            ),
            convert: VersionDeleteResponse::class,
        );
    }
}
