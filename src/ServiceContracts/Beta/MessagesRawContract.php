<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\MessageCountTokensParams;
use Anthropic\Beta\Messages\MessageCreateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

interface MessagesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|MessageCreateParams $params
     *
     * @return BaseResponse<BetaMessage>
     *
     * @throws APIException
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MessageCreateParams $params
     *
     * @return BaseResponse<BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent,>,>
     *
     * @throws APIException
     */
    public function createStream(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MessageCountTokensParams $params
     *
     * @return BaseResponse<BetaMessageTokensCount>
     *
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
