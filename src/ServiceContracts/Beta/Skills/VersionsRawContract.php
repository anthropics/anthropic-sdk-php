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
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

interface VersionsRawContract
{
    /**
     * @api
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array<string,mixed>|VersionCreateParams $params
     *
     * @return BaseResponse<VersionNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $skillID,
        array|VersionCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $version Path param: Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     * @param array<string,mixed>|VersionRetrieveParams $params
     *
     * @return BaseResponse<VersionGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        array|VersionRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array<string,mixed>|VersionListParams $params
     *
     * @return BaseResponse<PageCursor<VersionListResponse>>
     *
     * @throws APIException
     */
    public function list(
        string $skillID,
        array|VersionListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $version Path param: Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     * @param array<string,mixed>|VersionDeleteParams $params
     *
     * @return BaseResponse<VersionDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $version,
        array|VersionDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
