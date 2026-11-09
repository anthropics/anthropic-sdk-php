<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Skills\BetaDeletedSkill;
use Anthropic\Beta\Skills\BetaSkill;
use Anthropic\Beta\Skills\SkillCreateParams;
use Anthropic\Beta\Skills\SkillDeleteParams;
use Anthropic\Beta\Skills\SkillListParams;
use Anthropic\Beta\Skills\SkillRetrieveParams;
use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\CMEKContextUnavailableException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SkillsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SkillCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaSkill>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws OrganizationOnHoldException
     * @throws CMEKContextUnavailableException
     * @throws APIException
     */
    public function create(
        array|SkillCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array<string,mixed>|SkillRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaSkill>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        array|SkillRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SkillListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaSkill>>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function list(
        array|SkillListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param array<string,mixed>|SkillDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDeletedSkill>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function delete(
        string $skillID,
        array|SkillDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
