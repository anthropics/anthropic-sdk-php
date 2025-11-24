<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Skills\SkillCreateParams;
use Anthropic\Beta\Skills\SkillDeleteParams;
use Anthropic\Beta\Skills\SkillDeleteResponse;
use Anthropic\Beta\Skills\SkillGetResponse;
use Anthropic\Beta\Skills\SkillListParams;
use Anthropic\Beta\Skills\SkillListResponse;
use Anthropic\Beta\Skills\SkillNewResponse;
use Anthropic\Beta\Skills\SkillRetrieveParams;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

interface SkillsContract
{
    /**
     * @api
     *
     * @param array<mixed>|SkillCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        array|SkillCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): SkillNewResponse;

    /**
     * @api
     *
     * @param array<mixed>|SkillRetrieveParams $params
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        array|SkillRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): SkillGetResponse;

    /**
     * @api
     *
     * @param array<mixed>|SkillListParams $params
     *
     * @return PageCursor<SkillListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|SkillListParams $params,
        ?RequestOptions $requestOptions = null
    ): PageCursor;

    /**
     * @api
     *
     * @param array<mixed>|SkillDeleteParams $params
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        array|SkillDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): SkillDeleteResponse;
}
