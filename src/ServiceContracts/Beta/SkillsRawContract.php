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
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

interface SkillsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SkillCreateParams $params
     *
     * @return BaseResponse<SkillNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|SkillCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array<string,mixed>|SkillRetrieveParams $params
     *
     * @return BaseResponse<SkillGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        array|SkillRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SkillListParams $params
     *
     * @return BaseResponse<PageCursor<SkillListResponse>>
     *
     * @throws APIException
     */
    public function list(
        array|SkillListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array<string,mixed>|SkillDeleteParams $params
     *
     * @return BaseResponse<SkillDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        array|SkillDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
