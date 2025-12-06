<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Skills;

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
     * @param array{
     *   files?: list<string>|null, betas?: list<string>
     * }|VersionCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        string $skillID,
        array|VersionCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): VersionNewResponse {
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
     * @param array{
     *   skill_id: string, betas?: list<string>
     * }|VersionRetrieveParams $params
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        array|VersionRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): VersionGetResponse {
        [$parsed, $options] = VersionRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $skillID = $parsed['skill_id'];
        unset($parsed['skill_id']);

        // @phpstan-ignore-next-line return.type
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
     * @param array{
     *   limit?: int|null, page?: string|null, betas?: list<string>
     * }|VersionListParams $params
     *
     * @return PageCursor<VersionListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $skillID,
        array|VersionListParams $params,
        ?RequestOptions $requestOptions = null,
    ): PageCursor {
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
     * @param array{skill_id: string, betas?: list<string>}|VersionDeleteParams $params
     *
     * @throws APIException
     */
    public function delete(
        string $version,
        array|VersionDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): VersionDeleteResponse {
        [$parsed, $options] = VersionDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $skillID = $parsed['skill_id'];
        unset($parsed['skill_id']);

        // @phpstan-ignore-next-line return.type
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
