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
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @api
     *
     * @param array<mixed>|MessageCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessage;

    /**
     * @api
     *
     * @param array<mixed>|MessageCreateParams $params
     *
     * @return BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent,>
     *
     * @throws APIException
     */
    public function createStream(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseStream;

    /**
     * @api
     *
     * @param array<mixed>|MessageCountTokensParams $params
     *
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageTokensCount;
}
