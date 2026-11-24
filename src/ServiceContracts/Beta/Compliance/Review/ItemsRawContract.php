<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Compliance\Review;

use Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewItem;
use Anthropic\Beta\Compliance\Review\Items\ItemRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ItemsRawContract
{
    /**
     * @api
     *
     * @param string $itemID The ID of the item. For a message, its ID as the client received it or as a review case lists it, such as `msg_...`.
     * @param array<string,mixed>|ItemRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaComplianceReviewItem>
     *
     * @throws APIException
     */
    public function retrieve(
        string $itemID,
        array|ItemRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
