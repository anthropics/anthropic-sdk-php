<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewItem;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ItemsContract
{
    /**
     * @api
     *
     * @param string $itemID The ID of the item. For a message, its ID as the client received it or as a review case lists it, such as `msg_...`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional header to specify the beta version(s) you want to use.
     * @param string $userProfileID The ID of the user profile that the message was recorded with (`uprof_...`). Send it for a message recorded with a user profile, and leave it out for a message recorded with none.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $itemID,
        ?array $betas = null,
        ?string $userProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaComplianceReviewItem;
}
