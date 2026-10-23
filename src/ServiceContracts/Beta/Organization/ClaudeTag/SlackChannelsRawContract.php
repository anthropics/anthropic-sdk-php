<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagDeletedSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelCreateParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelDeleteParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelListParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelRetrieveParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SlackChannelsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SlackChannelCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws APIException
     */
    public function create(
        array|SlackChannelCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id path param: The channel's identifier, starting with `slch_`
     * @param array<string,mixed>|SlackChannelRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|SlackChannelRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id path param: The channel's identifier, starting with `slch_`
     * @param array<string,mixed>|SlackChannelUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|SlackChannelUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SlackChannelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagSlackChannel>>
     *
     * @throws APIException
     */
    public function list(
        array|SlackChannelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id the channel's identifier, starting with `slch_`
     * @param array<string,mixed>|SlackChannelDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagDeletedSlackChannel>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|SlackChannelDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
