<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\Versions\DeletedSkillVersion;
use Anthropic\Beta\Skills\Versions\SkillVersion;
use Anthropic\Beta\Skills\Versions\VersionCreateParams;
use Anthropic\Beta\Skills\Versions\VersionDeleteParams;
use Anthropic\Beta\Skills\Versions\VersionDownloadParams;
use Anthropic\Beta\Skills\Versions\VersionListParams;
use Anthropic\Beta\Skills\Versions\VersionRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Skills\VersionsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class VersionsRawService implements VersionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Skill Version
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array{
     *   files: list<string|FileParam>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|VersionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SkillVersion>
     *
     * @throws APIException
     */
    public function create(
        string $skillID,
        array|VersionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/skills/%1$s/versions?beta=true', $skillID],
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
            convert: SkillVersion::class,
        );
    }

    /**
     * @api
     *
     * Get Skill Version
     *
     * @param string $version Path param: Identifies the skill version: a version ID, or the literal `latest` for the skill's most recent version.
     *
     * Requests carrying the `skills-2025-10-02` beta header address versions by their Unix epoch timestamp instead (e.g., "1759178010641129").
     * @param array{
     *   skillID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|VersionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SkillVersion>
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        array|VersionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $skillID = $parsed['skillID'];
        unset($parsed['skillID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/skills/%1$s/versions/%2$s?beta=true', $skillID, $version],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: SkillVersion::class,
        );
    }

    /**
     * @api
     *
     * List Skill Versions
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array{
     *   limit?: int|null,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|VersionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SkillVersion>>
     *
     * @throws APIException
     */
    public function list(
        string $skillID,
        array|VersionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/skills/%1$s/versions?beta=true', $skillID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: SkillVersion::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete Skill Version
     *
     * @param string $version Path param: Identifies the skill version by its version ID.
     *
     * Requests carrying the `skills-2025-10-02` beta header address versions by their Unix epoch timestamp instead (e.g., "1759178010641129").
     * @param array{
     *   skillID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|VersionDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedSkillVersion>
     *
     * @throws APIException
     */
    public function delete(
        string $version,
        array|VersionDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $skillID = $parsed['skillID'];
        unset($parsed['skillID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/skills/%1$s/versions/%2$s?beta=true', $skillID, $version],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: DeletedSkillVersion::class,
        );
    }

    /**
     * @api
     *
     * Download a skill version's content as a zip archive.
     *
     * @param string $version Path param: Identifies the skill version by its version ID.
     *
     * Requests carrying the `skills-2025-10-02` beta header address versions by their Unix epoch timestamp instead (e.g., "1759178010641129").
     * @param array{
     *   skillID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|VersionDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function download(
        string $version,
        array|VersionDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionDownloadParams::parseRequest(
            $params,
            $requestOptions,
        );
        $skillID = $parsed['skillID'];
        unset($parsed['skillID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/skills/%1$s/versions/%2$s/content?beta=true', $skillID, $version,
            ],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/binary', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: $options,
            convert: 'string',
        );
    }
}
