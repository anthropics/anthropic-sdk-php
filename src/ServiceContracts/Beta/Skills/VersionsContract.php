<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Skills;

use Anthropic\Beta\Skills\Versions\VersionCreateParams;
use Anthropic\Beta\Skills\Versions\VersionDeleteParams;
use Anthropic\Beta\Skills\Versions\VersionDeleteResponse;
use Anthropic\Beta\Skills\Versions\VersionGetResponse;
use Anthropic\Beta\Skills\Versions\VersionListParams;
use Anthropic\Beta\Skills\Versions\VersionListResponse;
use Anthropic\Beta\Skills\Versions\VersionNewResponse;
use Anthropic\Beta\Skills\Versions\VersionRetrieveParams;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

interface VersionsContract
{
    /**
     * @api
     *
     * @param array<mixed>|VersionCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        string $skillID,
        array|VersionCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): VersionNewResponse;

    /**
     * @api
     *
     * @param array<mixed>|VersionRetrieveParams $params
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        array|VersionRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): VersionGetResponse;

    /**
     * @api
     *
     * @param array<mixed>|VersionListParams $params
     *
     * @return PageCursor<VersionListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $skillID,
        array|VersionListParams $params,
        ?RequestOptions $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param array<mixed>|VersionDeleteParams $params
     *
     * @throws APIException
     */
    public function delete(
        string $version,
        array|VersionDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): VersionDeleteResponse;
}
